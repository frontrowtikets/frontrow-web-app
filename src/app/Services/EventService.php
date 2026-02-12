<?php

namespace App\Services;

use App\Models\EventCategory;
use App\Models\Event;
use App\Models\EventCategoryLink;
use App\Models\EventTicket;
use Illuminate\Support\Facades\Auth;
use App\Models\EventReview;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\EventAttendee;
use Illuminate\Support\Facades\Mail;
use App\Models\UserEventTicket;
use App\Mail\NewUserTempPasswordMail;
use App\Models\UserPaymentDetail;
use App\Models\EventTicketCategory;
use App\Models\PaymentTransaction;
use App\Models\UserWallet;
use App\Mail\EventRegistrationOwnerMail;
use App\Mail\EventRegistrationUserMail;
use App\Mail\AcceptEventRegistrationUserMail;
use App\Mail\DeclineEventRegistrationUserMail;
use App\Mail\EventTicketPurchaseMail;

/**
 * Event Service.
 * This class is responsible for handing all functionalities related to events
 */
class EventService
{

    public function __construct() {}

    /**
     * Saving Events Settings
     */
    public static function saveSettings(array $settingsDetails)
    {

        //event categories
        EventCategory::truncate();
        EventTicketCategory::truncate();
        foreach ($settingsDetails['eventCategories'] as $category) {
            EventCategory::create([
                'name' => $category
            ]);
        }
        foreach ($settingsDetails['ticketCategories'] as $category) {
            EventTicketCategory::create([
                'name' => $category
            ]);
        }
    }

    public static function creteEvent($eventDetails)
    {

        $isEdit = null;
        if (isset($eventDetails['id']) && $eventDetails['id'] != '') {
            $isEdit = $eventDetails['id'];
        }

        $eventThumbnail = null;
        $createdEvent = Event::updateOrCreate([
            'id' => $isEdit
        ], [
            'beneficiary_id' => isset($eventDetails['beneficiary_id']) ? $eventDetails['beneficiary_id']  :  Auth::user()->id,
            'title' => $eventDetails['title'],
            'description' => $eventDetails['description'],
            'location_name' => $eventDetails['location_name'],
            'gps_location' => $eventDetails['gps_location'],
            'start_date' => $eventDetails['start_date'],
            'start_time' => $eventDetails['start_time'],
            'end_time' => $eventDetails['end_time'],
            'end_date' => $eventDetails['end_date'],
            'access_type' => $eventDetails['access_type'],
            'status' => $eventDetails['status'],
            'trailer_url' => $eventDetails['trailer_url']
        ]);

        if (isset($eventDetails['cardImage']) && !is_null($eventDetails['cardImage'])) {
            $cardImage = $createdEvent->addMedia($eventDetails['cardImage'])->toMediaCollection('event_images');
            $cardImageUrl = $cardImage->getUrl();
            $createdEvent->thumbnail_url = $cardImageUrl;
            $eventThumbnail = $cardImageUrl;
        }


        if (isset($eventDetails['bannerImage']) && !is_null($eventDetails['bannerImage'])) {
            $bannerImage = $createdEvent->addMedia($eventDetails['bannerImage'])->toMediaCollection('event_images');
            $bannerImageUrl = $bannerImage->getUrl();
            $createdEvent->banner_image_url = $bannerImageUrl;
        }
        $createdEvent->save();

        if (count($eventDetails['categories']) > 0) {
            EventCategoryLink::where('event_id', $createdEvent->id)->delete();
            foreach ($eventDetails['categories'] as $category) {
                EventCategoryLink::create([
                    'event_id' => $createdEvent->id,
                    'category_id' => $category['id'],
                ]);
            }
        }

        if (count($eventDetails['tickets']) > 0) {
            foreach ($eventDetails['tickets'] as $ticket) {
                EventTicket::updateOrCreate(['id' => isset($ticket['id']) ? $ticket['id'] : null], [
                    'event_id' => $createdEvent->id,
                    'category' => $ticket['category'],
                    'price' => $ticket['price'],
                    'available_quantity' => $ticket['quantity'],
                    'currency' => $ticket['currency'],
                    'ticket_thumbnail_url' => $eventThumbnail,
                ]);
            }
        }
    }

    public static function registerForEvent($requestDetails)
    {

        //create account if the account doesnt exist
        $currentUser = User::where('email', $requestDetails['email'])->first();
        if (is_null($currentUser)) {
            $randomPassword = Str::random(12);
            $currentUser = User::create(
                [
                    'name' => $requestDetails['name'],
                    'email' => $requestDetails['email'],
                    'phone_number' => $requestDetails['phone_number'],
                    'user_type' => 'ticket_buyer',
                    'password' => Hash::make($randomPassword),
                ]
            );
            Log::alert('TempPassword' . $randomPassword);
            //send email with temp. Password
            try {
                $message = (new NewUserTempPasswordMail($currentUser->name, $randomPassword))
                    ->onQueue('emails');

                Mail::to($currentUser->email)
                    ->queue($message);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
        $theEvent = Event::where('id', $requestDetails['event_id'])->with(['beneficiary'])->first();

        EventAttendee::updateOrCreate(
            [
                'event_id' => $requestDetails['event_id'],
                'email' => $currentUser->email
            ],
            [
                'user_id' => $currentUser->id,
                'reg_status' => 'pending'
            ]
        );
        try {
            $message = (new EventRegistrationOwnerMail($theEvent->beneficiary->name))
                ->onQueue('emails');

            Mail::to($theEvent->beneficiary->email)
                ->queue($message);
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            $message = (new EventRegistrationUserMail($currentUser->name, $theEvent->title))
                ->onQueue('emails');

            Mail::to($currentUser->email)
                ->queue($message);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public static function approveInvitation($requestDetails)
    {
        $attendanceDetail = EventAttendee::where('id', $requestDetails->attendace_id)->first();
        $attendanceDetail->reg_status = 'approved';
        $attendanceDetail->save();

        $currentUser = User::where('id', $attendanceDetail->user_id)->first();
        //creating ticket
        $userPaymentDetails = UserPaymentDetail::create([
            'user_id' => $currentUser->id,
            'full_name' => $currentUser->name,
            'user_email' => $currentUser->email,
            'user_phone_number' => $currentUser->phone_number,
            'payment_type' => 'free',
        ]);
        $paymentTransactions = PaymentTransaction::create([
            'txn_ref' => 'test',
            'mfscode' => 'test',
            'txn_type' => 'ticket_purchase',
            'txn_channel' => 'web',
            'txn_status' => 'pending',
            'amount' => 0,
            'currency' => 'UGX',
            'reason' => 'test',
            'phone_number' => $currentUser->phone_number,
            'user_id' => $currentUser->id,
            'txn_hash' => 'test'
        ]);


        $eventTicket = UserEventTicket::create([
            'user_id' => $currentUser->id,
            'event_id' => $attendanceDetail->event_id,
            'quantity' => 1,
            'total_amount' => 0,
            'ticket_status' => 'paid',
            'booking_date' => now(),
            'user_email' => $currentUser->email,
            'ticket_id' => self::generateRandomEventTicketId(),
            'user_payment_detail_id' => $userPaymentDetails->id,
            'payment_transaction_id' => $paymentTransactions->id,

        ]);

        try {
            $theEvent = Event::where('id', $attendanceDetail->event_id)->first();
            $message = (new AcceptEventRegistrationUserMail($currentUser->name, $theEvent->title))
                ->onQueue('emails');

            Mail::to($currentUser->email)
                ->queue($message);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public static function declineInvitation($requestDetails)
    {
        $attendanceDetail = EventAttendee::where('id', $requestDetails->attendace_id)->first();
        $attendanceDetail->reg_status = 'declined';
        $attendanceDetail->save();

        try {
            $theEvent = Event::where('id', $attendanceDetail->event_id)->first();
            $currentUser = User::where('id', $attendanceDetail->user_id)->first();
            $message = (new DeclineEventRegistrationUserMail($currentUser->name, $theEvent->title))
                ->onQueue('emails');

            Mail::to($currentUser->email)
                ->queue($message);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public static function createReview($reviewDetails)
    {
        EventReview::create([
            'event_id' => $reviewDetails['event_id'],
            'user_id' => $reviewDetails['user_id'],
            'review' => $reviewDetails['review'],
            'submitted_by' => $reviewDetails['submitted_by']
        ]);
    }

    public static function buyTicket($paymentDetails)
    {
        $eventTickets = [];

        //create account if user doesnt exist
        $currentUser = User::where('email', $paymentDetails['email'])->first();
        if (is_null($currentUser)) {
            $randomPassword = Str::random(12);
            $currentUser = User::create(
                [
                    'name' => $paymentDetails['name'],
                    'email' => $paymentDetails['email'],
                    'phone_number' => $paymentDetails['phoneNumber'],
                    'user_type' => 'ticket_buyer',
                    'password' => Hash::make($randomPassword),
                ]
            );
            Log::alert('TempPassword' . $randomPassword);
            //send email with temp. Password
            try {
                $message = (new NewUserTempPasswordMail($currentUser->name, $randomPassword))
                    ->onQueue('emails');

                Mail::to($currentUser->email)
                    ->queue($message);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }

        $userPaymentDetails = UserPaymentDetail::create([
            'user_id' => $currentUser->id,
            'full_name' => $paymentDetails['name'],
            'user_email' => $paymentDetails['email'],
            'user_phone_number' => $paymentDetails['phoneNumber'],
            'visa_card' => $paymentDetails['payment_account'],
            'payment_type' => $paymentDetails['payment_method'],
        ]);
        $paymentTransactions = PaymentTransaction::create([
            'txn_ref' => $paymentDetails['merchant_reference'],
            'mfscode' => $paymentDetails['confirmation_code'],
            'txn_type' => $paymentDetails['purpose'],
            'txn_channel' => 'web',
            'txn_status' => $paymentDetails['status'] == 1 || $paymentDetails['status'] == '1' ? 'paid' : 'failed',
            'amount' => $paymentDetails['total'],
            'currency' => $paymentDetails['currency'],
            'reason' => 'Paying for event tickets',
            'phone_number' => $paymentDetails['phoneNumber'],
            'user_id' => $currentUser->id,
            'txn_hash' => $paymentDetails['merchant_reference']
        ]);

        if ($paymentDetails['status'] == 1 || $paymentDetails['status'] == '1') {
            foreach ($paymentDetails['selectedTicket'] as $seat) {
                $ticketQuantity = $seat['selectedQuantity'];
                // Create multiple tickets for the same seat depending on the quantity
                for ($i = 0; $i < $ticketQuantity; $i++) {
                    $eventTicket = UserEventTicket::create([
                        'user_id' => $currentUser->id,
                        'event_id' => $seat['event_id'],
                        'quantity' => 1,
                        'total_amount' => $paymentDetails['total'] / $ticketQuantity,
                        'ticket_status' => 'paid',
                        'booking_date' => now(),
                        'user_email' => $paymentDetails['email'],
                        'ticket_id' => self::generateRandomEventTicketId(),
                        'event_ticket_id' => $seat['id'],
                        'user_payment_detail_id' => $userPaymentDetails->id,
                        'payment_transaction_id' => $paymentTransactions->id,
                    ]);
                    array_push($eventTickets, $eventTicket);
                }
            }
        }

        return $eventTickets;
    }
    public static  function payWithWallet($paymentDetails)
    {
        $currentUser = User::where('email', $paymentDetails['email'])->first();
        $userWallet = UserWallet::where('user_id', $currentUser->id)->first();

        if ($userWallet->balance >  $paymentDetails['amount']) {
            $eventTickets = [];
            $userPaymentDetails = UserPaymentDetail::create([
                'user_id' => $currentUser->id,
                'full_name' => $paymentDetails['first_name'] . ' ' . $paymentDetails['last_name'],
                'user_email' => $paymentDetails['email'],
                'user_phone_number' => $paymentDetails['phone'],
                'visa_card' => 'wallet',
                'payment_type' => 'wallet',
            ]);
            $paymentTransactions = PaymentTransaction::create([
                'txn_ref' => $userWallet->id,
                'mfscode' => $userWallet->id,
                'txn_type' => 'event_ticket',
                'txn_channel' => 'web',
                'txn_status' =>  'paid',
                'amount' => $paymentDetails['amount'],
                'currency' => 'UGX',
                'reason' => 'Paying for event tickets',
                'phone_number' => $paymentDetails['phone'],
                'user_id' => $currentUser->id,
                'txn_hash' => $userWallet->id
            ]);


            foreach ($paymentDetails['selectedTicket'] as $seat) {
                $ticketQuantity = $seat['selectedQuantity'];
                // Create multiple tickets for the same seat depending on the quantity
                for ($i = 0; $i < $ticketQuantity; $i++) {
                    $eventTicket = UserEventTicket::create([
                        'user_id' => $currentUser->id,
                        'event_id' => $seat['event_id'],
                        'quantity' => 1,
                        'total_amount' => $paymentDetails['total'] / $ticketQuantity,
                        'ticket_status' => 'paid',
                        'booking_date' => now(),
                        'user_email' => $paymentDetails['email'],
                        'ticket_id' => self::generateRandomEventTicketId(),
                        'event_ticket_id' => $seat['id'],
                        'user_payment_detail_id' => $userPaymentDetails->id,
                        'payment_transaction_id' => $paymentTransactions->id,
                    ]);
                    array_push($eventTickets, $eventTicket);
                }
            }

            $userWallet->balance = $userWallet->balance - $paymentDetails['amount'];
            $userWallet->save();

            //Ticket Email
            try {
                $cleanedTicketData = [];
                foreach ($eventTickets as $createdTicket) {
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
    public static function adminCreateTicket($data)
    {
        $isNewUser = false;

        // Find or create user
        $currentUser = User::where('email', $data['customer_email'])->first();
        if (is_null($currentUser)) {
            $isNewUser = true;
            $randomPassword = Str::random(12);
            $currentUser = User::create([
                'name' => $data['customer_name'],
                'email' => $data['customer_email'],
                'phone_number' => $data['customer_phone'],
                'user_type' => 'ticket_buyer',
                'password' => Hash::make($randomPassword),
            ]);
            try {
                $message = (new NewUserTempPasswordMail($currentUser->name, $randomPassword))
                    ->onQueue('emails');
                Mail::to($currentUser->email)->queue($message);
            } catch (\Throwable $th) {
                Log::error('Failed to send temp password email: ' . $th->getMessage());
            }
        }

        // Create payment detail
        $userPaymentDetails = UserPaymentDetail::create([
            'user_id' => $currentUser->id,
            'full_name' => $data['customer_name'],
            'user_email' => $data['customer_email'],
            'user_phone_number' => $data['customer_phone'],
            'payment_type' => $data['payment_method'],
        ]);

        // Create payment transaction
        $paymentTransaction = PaymentTransaction::create([
            'txn_ref' => $data['payment_reference'],
            'mfscode' => $data['payment_reference'],
            'txn_type' => 'event_ticket',
            'txn_channel' => 'admin',
            'txn_status' => 'paid',
            'amount' => $data['amount'],
            'currency' => 'UGX',
            'reason' => 'Admin-created event ticket',
            'phone_number' => $data['customer_phone'],
            'user_id' => $currentUser->id,
            'txn_hash' => $data['payment_reference'],
        ]);

        // Create ticket records
        $tickets = [];
        $quantity = (int) $data['quantity'];
        for ($i = 0; $i < $quantity; $i++) {
            $ticket = UserEventTicket::create([
                'user_id' => $currentUser->id,
                'event_id' => $data['event_id'],
                'quantity' => 1,
                'total_amount' => $data['amount'] / $quantity,
                'ticket_status' => 'paid',
                'booking_date' => now(),
                'user_email' => $data['customer_email'],
                'ticket_id' => self::generateRandomEventTicketId(),
                'event_ticket_id' => $data['event_ticket_id'],
                'user_payment_detail_id' => $userPaymentDetails->id,
                'payment_transaction_id' => $paymentTransaction->id,
            ]);
            $tickets[] = $ticket;
        }

        return [
            'user' => $currentUser,
            'tickets' => $tickets,
            'transaction' => $paymentTransaction,
            'is_new_user' => $isNewUser,
        ];
    }

    private static  function generateRandomEventTicketId()
    {
        $prefix = "FRE";
        $uniqueId = $prefix . strtoupper(Str::random(15));
        return $uniqueId;
    }
}
