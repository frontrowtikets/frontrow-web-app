<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Support\Facades\Mail;
use App\Mail\EventTicketPurchaseMail;
use App\Mail\TicketPurchaseMail;
use App\Models\Movie;
use App\Models\MovieShowTimeSeat;
use App\Models\PaymentTransaction;
use App\Models\MovieShowTime;
use App\Models\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketEmailController extends Controller
{
    public function sendMovieTicketEmail(Request $request)
    {

        try {
            $createdTickets = $request->createdTickets;
            $paymentDetails = $request->paymentDetails;
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
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function sendEventTicketEmail(Request $request)
    {
        try {
            $cleanedTicketData = [];
            $createdTickets = $request->createdTickets;
            $paymentDetails = $request->paymentDetails;
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
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
