<?php

namespace App\Services;

use App\Models\MovieCategory;
use App\Models\Movie;
use Illuminate\Support\Facades\Auth;
use App\Models\MovieCategoryLink;
use App\Models\MovieShowTime;
use App\Models\MovieRating;
use App\Models\MovieReview;
use App\Models\SeatMap;
use App\Models\MovieShowTimeSeat;
use App\Models\MovieCast;
use App\Models\User;
use App\Mail\NewUserTempPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\MovieTicket;
use App\Models\UserPaymentDetail;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\Log;
use App\Models\UserWallet;
use App\Mail\MovieCreationAdminMail;
use App\Mail\MovieCreationOriginatorMail;
use App\Mail\TicketPurchaseMail;


/**
 * Event Service.
 * This class is responsible for handing all functionalities related to events
 */
class MovieService
{

    public function __construct() {}

    /**
     * Saving Events Settings
     */
    public static function saveSettings(array $settingsDetails)
    {

        //event categories
        MovieCategory::truncate();
        foreach ($settingsDetails['movieCategories'] as $category) {
            MovieCategory::create([
                'name' => $category
            ]);
        }
    }

    public static function createMovie($movieDetails)
    {

        $isEdit = null;
        if (isset($movieDetails['id']) && $movieDetails['id'] != '') {
            $isEdit = $movieDetails['id'];
        }

        $createdMovie = Movie::updateOrCreate([
            'id' => $isEdit
        ], [
            'beneficiary_id' => isset($movieDetails['beneficiary_id']) && !is_null($movieDetails['beneficiary_id']) ? $movieDetails['beneficiary_id']  :  Auth::user()->id,
            'title' => $movieDetails['title'],
            'description' => $movieDetails['description'],
            'release_date' => $movieDetails['release_date'],
            'duration' => $movieDetails['duration'],
            'languange' => $movieDetails['language'],
            'trailer_url' => $movieDetails['trailer_url'],
            'status' => $movieDetails['status'],
            'director' => $movieDetails['director'],
            'writer' => $movieDetails['writer'],
            'producer' => $movieDetails['producer'],
            'viewingFormat' => $movieDetails['viewingFormat'],
            'maturity_rating' => $movieDetails['maturity_rating'] ?? '13+',
        ]);

        if (isset($movieDetails['cardImage']) && !is_null($movieDetails['cardImage'])) {
            $cardImage = $createdMovie->addMedia($movieDetails['cardImage'])->toMediaCollection('movie_images');
            $cardImageUrl = $cardImage->getUrl();
            $createdMovie->thumbnail_url = $cardImageUrl;
        }


        if (isset($movieDetails['bannerImage']) && !is_null($movieDetails['bannerImage'])) {
            $bannerImage = $createdMovie->addMedia($movieDetails['bannerImage'])->toMediaCollection('movie_images');
            $bannerImageUrl = $bannerImage->getUrl();
            $createdMovie->poster_url = $bannerImageUrl;
        }
        $createdMovie->save();

        if (count($movieDetails['categories']) > 0) {
            MovieCategoryLink::where('movie_id', $createdMovie->id)->delete();
            foreach ($movieDetails['categories'] as $category) {
                MovieCategoryLink::create([
                    'movie_id' => $createdMovie->id,
                    'category_id' => $category['id'],
                ]);
            }
        }

        if (count($movieDetails['tickets']) > 0 && is_null($isEdit)) {
            foreach ($movieDetails['tickets'] as $ticket) {
               $movieShowtime =  MovieShowTime::updateOrCreate(['id' => isset($ticket['id']) ? $ticket['id'] : null], [
                    'movie_id' => $createdMovie->id,
                    'theatre' => $ticket['theatre']['theatre'],
                    'screening_date' => $ticket['screening_date'],
                    'start_time' => $ticket['start_time'],
                    'end_time' => $ticket['end_time'],
                    'currency' => $ticket['currency'],
                    'ticket_price' => $ticket['ticket_price'],
                ]);
                //saving seatmaps
                if(isset($ticket['addedSeatMaps'] )){


                    $createdSeatMap = SeatMap::create([
                        'movie_id' => $createdMovie->id,
                        'movie_show_time_id' => $movieShowtime->id,
                        'room_name' => $ticket['theatre']['room'],
                    ]);

                    foreach ($ticket['addedSeatMaps'] as $seatLabel) {
                        MovieShowTimeSeat::create([
                            'movie_show_time_id' => $movieShowtime->id,
                            'seat_map_id' => $createdSeatMap->id,
                            'seat_number' => $seatLabel['label'],
                            'seat_status' =>  'available',
                            'row_name' => $seatLabel['label'][0]
                        ]);
                    }

                }
            }
        }
        if (count($movieDetails['tickets']) > 0 && !is_null($isEdit)){
            foreach ($movieDetails['tickets'] as $ticket) {
                $movieShowtime =  MovieShowTime::updateOrCreate(['id' => isset($ticket['id']) ? $ticket['id'] : null], [
                     'movie_id' => $createdMovie->id,
                     'theatre' => $ticket['theatre'],
                     'screening_date' => $ticket['screening_date'],
                     'start_time' => $ticket['start_time'],
                     'end_time' => $ticket['end_time'],
                     'currency' => $ticket['currency'],
                     'ticket_price' => $ticket['ticket_price'],
                 ]);
                 //saving seatmaps
                 if(isset($ticket['addedSeatMaps'] )){


                     $createdSeatMap = SeatMap::create([
                         'movie_id' => $createdMovie->id,
                         'movie_show_time_id' => $movieShowtime->id,
                         'room_name' => $ticket['theatre']['room'],
                     ]);

                     foreach ($ticket['addedSeatMaps'] as $seatLabel) {
                         MovieShowTimeSeat::create([
                             'movie_show_time_id' => $movieShowtime->id,
                             'seat_map_id' => $createdSeatMap->id,
                             'seat_number' => $seatLabel['label'],
                             'seat_status' =>  'available',
                             'row_name' => $seatLabel['label'][0]
                         ]);
                     }

                 }
             }
        }

        // if (count($movieDetails['casts']) > 0) {
        //     foreach ($movieDetails['casts'] as $cast) {

        //         $isCastEdit = null;
        //         if (isset($cast['id']) && $cast['id'] != '') {
        //             $isCastEdit = $cast['id'];
        //         }


        //         $moviecast = MovieCast::updateOrCreate(['id' => $isCastEdit], [
        //             'movie_id' => $createdMovie->id,
        //             'name' => $cast['castName'],
        //             'role' => $cast['role'],
        //             'type' => $cast['type']
        //         ]);

        //         if (isset($cast['image']) && !is_null($cast['image']) && $cast['image'] != 'null') {
        //             $castImage = $createdMovie->addMedia($cast['image'])->toMediaCollection('casts_profile_images');
        //             $castImageUrl = $castImage->getUrl();
        //             $moviecast->profile_image_url = $castImageUrl;
        //         }
        //         $moviecast->save();
        //     }
        // }

        MovieRating::create([
            'movie_id' => $createdMovie->id,
            'user_id' => $createdMovie->beneficiary_id,
            'rating' => $movieDetails['rating'],
        ]);

        $admins = User::permission('admin')->get();
        $currentUser =  User::where('id', Auth::user()->id)->first();
        foreach ($admins as $admin) {
            try {
                $message = (new MovieCreationAdminMail($admin->name))
                    ->onQueue('emails');

                Mail::to($admin->email)
                    ->queue($message);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }

        try {
            $message = (new MovieCreationOriginatorMail($currentUser->name))
                ->onQueue('emails');

            Mail::to($currentUser->email)
                ->queue($message);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public static function saveSeatMap($seatmapDetails)
    {
        foreach ($seatmapDetails as $seatmapDetail) {

            $seatMapId = null;

            if (array_key_exists('seatmapId', $seatmapDetail) && !is_null($seatmapDetail['seatmapId']) && $seatmapDetail['seatmapId'] != "null") {
                $seatMapId = $seatmapDetail['seatmapId'];
            }

            $createdSeatMap = SeatMap::updateOrCreate([
                'id' => $seatMapId
            ], [
                'movie_id' => $seatmapDetail['showTime']['movie_id'],
                'movie_show_time_id' => $seatmapDetail['showTime']['id'],
                'room_name' => $seatmapDetail['roomName'],
            ]);

            // update MovieShowTime with show_room, used in the Mobile App
            MovieShowTime::where('id', $seatmapDetail['showTime']['id'])
                ->update([
                    'show_room' => $seatmapDetail['roomName']
                ]);

            MovieShowTimeSeat::where('seat_map_id', $createdSeatMap->id)->forceDelete();

            foreach ($seatmapDetail['combinations'] as $seatLabel) {


                MovieShowTimeSeat::create([
                    'movie_show_time_id' => $seatmapDetail['showTime']['id'],
                    'seat_map_id' => $createdSeatMap->id,
                    'seat_number' => $seatLabel['label'],
                    'seat_status' => in_array($seatLabel['label'], $seatmapDetail['reserved']) ? 'reserved' : 'available',
                    'row_name' => $seatLabel['label'][0]
                ]);
            }
        }
    }

    public static function deleteSeatMap($seatMapId)
    {
        SeatMap::where('id', $seatMapId)->forceDelete();
    }

    public static function createReview($reviewDetails)
    {
        MovieReview::create([
            'movie_id' => $reviewDetails['movie_id'],
            'user_id' => $reviewDetails['user_id'],
            'review' => $reviewDetails['review'],
            'submitted_by' => $reviewDetails['submitted_by']
        ]);
    }

    public static function buyTicket($paymentDetails)
    {

        $movieTickets = [];

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

        //Movie Tickets
        $userPaymentDetails = UserPaymentDetail::create([
            'user_id' => $currentUser->id,
            'full_name' => $paymentDetails['name'],
            'user_email' => $paymentDetails['email'],
            'user_phone_number' => $paymentDetails['email'],
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

        // get transaction details
        // $paymentTransactions = PaymentService::collect(60000, '0782033409', $user)->max_attempts(1)->pay();
        if ($paymentDetails['status'] == 1 || $paymentDetails['status'] == '1') {
            foreach ($paymentDetails['selectedSeatsDetails'] as $ticket) {

                foreach ($ticket['selectedSeats'] as $seat) {
                    $showTimeSeat = MovieShowTimeSeat::where('movie_show_time_id', $ticket['theatreId'])->where('seat_map_id', $ticket['roomId'])->where('seat_number', $seat)->first();
                    $showTimeSeat->seat_status = 'reserved';
                    $showTimeSeat->save();
                    $ticket = MovieTicket::create([
                        'movie_id' => $paymentDetails['movieId'],
                        'user_email' => $paymentDetails['email'],
                        'movie_show_time_id' => $ticket['theatreId'],
                        'movie_show_time_seat_id' => $showTimeSeat->id,
                        'purchase_date' => now(),
                        'user_payment_detail_id' => $userPaymentDetails->id,
                        'payment_transaction_id' => $paymentTransactions->id,
                        'ticket_id' => self::generateRandomMovieTicketId(),
                        'ticket_status' => 'paid'
                    ]);

                    array_push($movieTickets, $ticket);
                }
            }
        }

        return $movieTickets;
    }

    public static  function payWithWallet($paymentDetails)
    {
        $currentUser = User::where('email', $paymentDetails['email'])->first();
        $userWallet = UserWallet::where('user_id', $currentUser->id)->first();

        if ($userWallet->balance >  $paymentDetails['amount']) {
            $movieTickets = [];
            //Movie Tickets
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
                'txn_type' => 'movie_ticket',
                'txn_channel' => 'web',
                'txn_status' =>  'paid',
                'amount' => $paymentDetails['amount'],
                'currency' => 'UGX',
                'reason' => 'Paying for event tickets',
                'phone_number' => $paymentDetails['phone'],
                'user_id' => $currentUser->id,
                'txn_hash' => $userWallet->id
            ]);


            foreach ($paymentDetails['selectedSeatsDetails'] as $ticket) {

                foreach ($ticket['selectedSeats'] as $seat) {
                    $showTimeSeat = MovieShowTimeSeat::where('movie_show_time_id', $ticket['theatreId'])->where('seat_map_id', $ticket['roomId'])->where('seat_number', $seat)->first();
                    $showTimeSeat->seat_status = 'reserved';
                    $showTimeSeat->save();
                    $ticket = MovieTicket::create([
                        'movie_id' => $paymentDetails['movieId'],
                        'user_email' => $paymentDetails['email'],
                        'movie_show_time_id' => $ticket['theatreId'],
                        'movie_show_time_seat_id' => $showTimeSeat->id,
                        'purchase_date' => now(),
                        'user_payment_detail_id' => $userPaymentDetails->id,
                        'payment_transaction_id' => $paymentTransactions->id,
                        'ticket_id' => self::generateRandomMovieTicketId(),
                        'ticket_status' => 'paid'
                    ]);
                    array_push($movieTickets, $ticket);
                }
            }
            $userWallet->balance = $userWallet->balance - $paymentDetails['amount'];
            $userWallet->save();

            //Ticket Email
            try {
                $cleanedTicketData = [];
                foreach ($movieTickets as $createdTicket) {
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
    }
    private static  function generateRandomMovieTicketId()
    {
        $prefix = "FRM";
        $uniqueId = uniqid($prefix, true);
        $uniqueId = str_replace('.', '', $uniqueId);
        return substr($uniqueId, 0, 18);
    }


}
