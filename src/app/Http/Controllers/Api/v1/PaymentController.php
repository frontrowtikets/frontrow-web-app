<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\MovieTicket;
use App\Models\UserPaymentDetail;
use Illuminate\Http\Request;
use App\Services\PaymentService;
use App\Models\UserEventTicket;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\PesaPalPayment;
use App\Services\PesapalService;
use App\Services\EventService;
use App\Services\MovieService;
use App\Http\Controllers\WalletController;
use App\Mail\TicketPurchaseMail;
use App\Models\Movie;
use App\Models\Event;
use App\Models\MovieShowTime;
use App\Models\MovieShowTimeSeat;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventTicketPurchaseMail;
use Carbon\Carbon;


class PaymentController extends Controller
{

    private $pesapal;

    public function __construct(PesapalService $pesapal)
    {
        $this->pesapal = $pesapal;
    }

    public function initiateCollection(Request $request)

    {
        try {
            $transaction = PaymentService::collect(
                $request->amount,
                $request->phone_number,
                $request->user_id,
                $request->currency,
                [
                    'payment_method' => 'mobile_money',
                    'txn_channel' => 'postman',
                    'txn_type' => 'wallet',
                    'prefix' => ltrim(substr($request->phone_number, 0, 4), '0'),
                ]
            )->max_attempts(1)->pay();

            return response()->json([
                'message' => 'Payment request sent successfully',
                'transaction' => $transaction,
            ], 200);
            $validated = $request->validate([
                'amount' => 'required|numeric',
                'currency' => 'required|string',
                'payment_method' => 'required|string',
                'payment_details_id' => 'required|numeric',
                'txn_channel' => 'required|string',
                'txn_type' => 'required|string',
                'booking_id' => 'numeric|nullable',
            ]);

            // if not valid, return error
            if (count($validated) < 6) {
                return response()->json([
                    'message' => 'Invalid request data',
                ], 400);
            }

            $amount = $validated['amount'];
            $currency = $validated['currency'];
            $payment_method = $validated['payment_method']; // mobile_money, visa_card
            $payment_details_id = (int)$validated['user_id'];
            $txn_channel = $validated['txn_channel']; // app, web
            $txn_type = $validated['txn_type']; // wallet, ticket_purchase
            $booking_id = $validated['booking_id'];

            $paymentDetails = UserPaymentDetail::find($payment_details_id);
            if (!$paymentDetails) {
                return response()->json([
                    'message' => 'Payment details not found',
                ], 404);
            }

            $user_id = $paymentDetails->user_id;
            $phone_number = $paymentDetails->phone_number;
            if ($txn_type == 'wallet') {
                return PaymentService::wallet(
                    $amount,
                    $phone_number,
                    $user_id,
                    $currency,
                    [
                        'payment_method' => $payment_method,
                        'txn_channel' => $txn_channel,
                        'txn_type' => $txn_type,
                        'prefix' => ltrim(substr($phone_number, 0, 4), '0'),
                    ]
                )->max_attempts(1)->deposit();
            }
            // other transaction types
            $transaction = PaymentService::collect(
                $amount,
                $phone_number,
                $user_id,
                $currency,
                [
                    'payment_method' => $payment_method,
                    'txn_channel' => $txn_channel,
                    'txn_type' => $txn_type,
                    'prefix' => ltrim(substr($phone_number, 0, 4), '0'),
                ]
            )->max_attempts(1)->pay();

            // update tickets with a transaction id payment details id
            if ($booking_id) {
                $booking = MovieTicket::find($booking_id);
                if (!$booking) {
                    // check in UserEventTicket
                    $booking = UserEventTicket::find($booking_id);
                }
                $booking->update([
                    'transaction_id' => $transaction->id,
                    'payment_details_id' => $payment_details_id,
                ]);
            }
            return response()->json([
                'message' => 'Payment request sent successfully',
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error("Payment Initiation: " . $th->getMessage(), $th->getTrace());
            return response()->json([
                'message' => 'An error occurred while processing your request',
            ], 500);
        }
    }

    /**
     * Pesapal
     */

    public function makePayment(PesaPalPayment $request)
    {
        $orderDetails = $request->validated();

        $response = $this->pesapal->submitOrder($orderDetails);
        Log::alert($response);

        return response($response['redirect_url']);
    }

    public function getPaymentStatus(Request $request)
    {
        try {
            $orderTrackingId = $request->orderTrackingId;
            $status = $this->pesapal->getPaymentStatus($orderTrackingId);
            if ($request->purpose == 'event') {
                $paymentDetails = [
                    'name' => $request->username,
                    'email' => $request->userEmail,
                    'phoneNumber' => $request->phone,
                    'purpose' => 'event_ticket',
                    'selectedTicket' => $request->selectedTicket,
                    'status' => $status['status_code'],
                    'payment_account' => $status['payment_account'],
                    'payment_method' => $status['payment_method'],
                    'currency' => $status['currency'],
                    'total' => $status['amount'],
                    'merchant_reference' => $status['merchant_reference'],
                    'confirmation_code' => $status['confirmation_code'],
                    'call_back_url' => $status['call_back_url']
                ];
                $createdTickets = EventService::buyTicket($paymentDetails);
                $cleanedTicketData = [];
                foreach ($createdTickets as $createdTicket) {
                    $event = Event::where('id', $createdTicket->event_id)->first();
                    $transactionDetails = PaymentTransaction::where('id', $createdTicket->payment_transaction_id)->first();

                    $cleaned = [
                        'event' => $event,
                        'transactionDetails' => $transactionDetails,
                        'ticketId' => $createdTicket->ticket_id
                    ];
                    array_push($cleanedTicketData, $cleaned);
                }

                $timestamp = strtotime(now());
                $formattedDate = date('D, M d Y H:i:s', $timestamp);
                $message = (new EventTicketPurchaseMail($paymentDetails['name'], $paymentDetails['total'], $paymentDetails['merchant_reference'], $paymentDetails['confirmation_code'], $paymentDetails['payment_method'], $formattedDate, $cleanedTicketData))
                    ->onQueue('emails');

                Mail::to($paymentDetails['email'])
                    ->queue($message);
            } elseif ($request->purpose == 'movie') {
                $paymentDetails = [
                    'name' => $request->username,
                    'email' => $request->userEmail,
                    'phoneNumber' => $request->phone,
                    'movieId' => $request->movieId,
                    'purpose' => 'movie_ticket',
                    'selectedSeatsDetails' => $request->selectedSeatsDetails,
                    'status' => $status['status_code'],
                    'payment_account' => $status['payment_account'],
                    'payment_method' => $status['payment_method'],
                    'currency' => $status['currency'],
                    'total' => $status['amount'],
                    'merchant_reference' => $status['merchant_reference'],
                    'confirmation_code' => $status['confirmation_code'],
                    'call_back_url' => $status['call_back_url']
                ];
                $createdTickets = MovieService::buyTicket($paymentDetails);
                $cleanedTicketData = [];
                foreach ($createdTickets as $createdTicket) {
                    $movie = Movie::where('id', $createdTicket->movie_id)->first();
                    $theatre = MovieShowTime::where('id', $createdTicket->movie_show_time_id)->first();
                    $transactionDetails = PaymentTransaction::where('id', $createdTicket->payment_transaction_id)->first();
                    $seatDetails = MovieShowTimeSeat::where('id', $createdTicket->movie_show_time_seat_id)->first();

                    $cleaned = [
                        'theatre' => $theatre,
                        'transactionDetails' => $transactionDetails,
                        'movie' => $movie,
                        'seatDetails' => $seatDetails,
                        'ticketId' => $createdTicket->ticket_id
                    ];
                    array_push($cleanedTicketData, $cleaned);
                }

                $timestamp = strtotime(now());
                $formattedDate = date('D, M d Y H:i:s', $timestamp);
                $message = (new TicketPurchaseMail($paymentDetails['name'], $paymentDetails['total'], $paymentDetails['merchant_reference'], $paymentDetails['confirmation_code'], $paymentDetails['payment_method'], $formattedDate, $cleanedTicketData))
                    ->onQueue('emails');

                Mail::to($paymentDetails['email'])
                    ->queue($message);
            } elseif ($request->purpose == 'wallet') {
                $wallet = new  WalletController();
                $paymentDetails = [
                    'userId' => $request->userId,
                    'amount' => $request->amount,
                    'purpose' => 'wallet_topup',
                    'status' => $status['status_code'],
                    'payment_account' => $status['payment_account'],
                    'payment_method' => $status['payment_method'],
                    'currency' => $status['currency'],
                    'total' => $status['amount'],
                    'merchant_reference' => $status['merchant_reference'],
                    'confirmation_code' => $status['confirmation_code'],
                    'call_back_url' => $status['call_back_url']
                ];
                $wallet->topUp($paymentDetails);
            }


            return response()->json([
                'success' => true,
                'data' => $status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function testMail(Request $request)
    {
        try {
            $testMovieTickets = MovieTicket::take(2)->latest()->get();
            $cleanedTicketData = [];
            foreach ($testMovieTickets as $testMovieTicket) {
                $movie = Movie::where('id', $testMovieTicket->movie_id)->first();
                $theatre = MovieShowTime::where('id', $testMovieTicket->movie_show_time_id)->first();
                $transactionDetails = PaymentTransaction::where('id', $testMovieTicket->payment_transaction_id)->first();
                $seatDetails = MovieShowTimeSeat::where('id', $testMovieTicket->movie_show_time_seat_id)->first();

                $cleaned = [
                    'theatre' => $theatre,
                    'transactionDetails' => $transactionDetails,
                    'movie' => $movie,
                    'seatDetails' => $seatDetails,
                    'ticketId' => $testMovieTicket->ticket_id
                ];
                array_push($cleanedTicketData, $cleaned);
            }

            $timestamp = strtotime('2025-01-22 20:24:30');
            $formattedDate = date('D, M d Y H:i:s', $timestamp);
            $message = (new TicketPurchaseMail('jemy Knd', 1200, 'this is the ref', 'thecode', 'MTNUG', $formattedDate, $cleanedTicketData))
                ->onQueue('emails');

            Mail::to('test2@gmail.com')
                ->queue($message);
        } catch (\Exception $e) {
            Log::alert($e);
        }

        try {
            $testMovieTickets = UserEventTicket::take(2)->latest()->get();
            $cleanedTicketData = [];
            foreach ($testMovieTickets as $testMovieTicket) {
                $event = Event::where('id', $testMovieTicket->event_id)->first();
                $transactionDetails = PaymentTransaction::where('id', $testMovieTicket->payment_transaction_id)->first();

                $cleaned = [
                    'event' => $event,
                    'transactionDetails' => $transactionDetails,
                    'ticketId' => $testMovieTicket->ticket_id
                ];
                array_push($cleanedTicketData, $cleaned);
            }

            $timestamp = strtotime(now());
            $formattedDate = date('D, M d Y H:i:s', $timestamp);
            $message = (new EventTicketPurchaseMail('jemy Knd', 1200, 'this is the ref', 'thecode', 'MTNUG', $formattedDate, $cleanedTicketData))
                ->onQueue('emails');

            Mail::to('test2@gmail.com')
                ->queue($message);
        } catch (\Exception $e) {
            Log::alert($e);
        }
    }

    public function testMail2(Request $request)
    {
        try {
            $testMovieTickets = MovieTicket::take(2)->latest()->get();
            $cleanedTicketData = [];
            foreach ($testMovieTickets as $testMovieTicket) {
                $movie = Movie::where('id', $testMovieTicket->movie_id)->first();
                $theatre = MovieShowTime::where('id', $testMovieTicket->movie_show_time_id)->first();
                $transactionDetails = PaymentTransaction::where('id', $testMovieTicket->payment_transaction_id)->first();
                $seatDetails = MovieShowTimeSeat::where('id', $testMovieTicket->movie_show_time_seat_id)->first();

                $cleaned = [
                    'theatre' => $theatre,
                    'transactionDetails' => $transactionDetails,
                    'movie' => $movie,
                    'seatDetails' => $seatDetails,
                    'ticketId' => $testMovieTicket->ticket_id
                ];
                array_push($cleanedTicketData, $cleaned);
            }

            $timestamp = strtotime('2025-01-22 20:24:30');
            $formattedDate = date('D, M d Y H:i:s', $timestamp);
            $message = new TicketPurchaseMail('jemy Knd', 1200, 'this is the ref', 'thecode', 'MTNUG', $formattedDate, $cleanedTicketData);


            Mail::to('test2@gmail.com')->send($message);
        } catch (\Exception $e) {
            Log::alert($e);
        }

        try {
            $testMovieTickets = UserEventTicket::take(2)->latest()->get();
            $cleanedTicketData = [];
            foreach ($testMovieTickets as $testMovieTicket) {
                $event = Event::where('id', $testMovieTicket->event_id)->first();
                $transactionDetails = PaymentTransaction::where('id', $testMovieTicket->payment_transaction_id)->first();

                $cleaned = [
                    'event' => $event,
                    'transactionDetails' => $transactionDetails,
                    'ticketId' => $testMovieTicket->ticket_id
                ];
                array_push($cleanedTicketData, $cleaned);
            }

            $timestamp = strtotime(now());
            $formattedDate = date('D, M d Y H:i:s', $timestamp);
            $message = new EventTicketPurchaseMail('jemy Knd', 1200, 'this is the ref', 'thecode', 'MTNUG', $formattedDate, $cleanedTicketData);


            Mail::to('test2@gmail.com')->send($message);
        } catch (\Exception $e) {
            Log::alert($e);
        }
    }
}
