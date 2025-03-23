<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\UserRegister;
use App\Http\Controllers\ActivationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::get('/events', [EventsController::class, 'homeEvents'])->name('events_home_page');
Route::get('/movies', [MoviesController::class, 'homeMovies'])->name('movies_home_page');

Route::get('/verify/movie/ticket/{ticketId}/{transactionId}/{userDetailsId}', [MoviesController::class, 'verifyTicket'])->name('verifyTicket');
Route::get('/verify/event/ticket/{ticketId}/{transactionId}/{userDetailsId}', [EventsController::class, 'verifyTicket'])->name('verifyTicket');

Route::get("/home/movie/{title}/{id}", [MoviesController::class, 'movieDetailHome'])->name('movie_detail_home');
Route::get("/home/event/{title}/{id}", [EventsController::class, 'eventDetailHome'])->name('event_detail_home');
Route::get("/home/movie/buy-ticket/{title}/{id}", [MoviesController::class, 'buyMovieTicketHome'])->name('movie_buy_ticket_home');
Route::get("/search", [SearchController::class, 'search'])->name('search');
// privacy policy
Route::get("/privacy-policy", function () {
    return inertia('PrivacyPolicy');
})->name('privacy_policy');

// terms and conditions
Route::get("/terms-and-conditions", function () {
    return inertia('TermsAndConditions');
})->name('terms_and_conditions');

// delete My Account
Route::get("/delete-my-account", function () {
    return inertia('DeleteMyAccount');
})->name('delete_my_account');

// post delete My Account
Route::post("/delete-my-account", [UserRegister::class, 'deleteMyAccount'])->name('delete_my_account_request');

//web payments callback
Route::get("/verify/payment", [PaymentController::class, 'verifyPayment'])->name('verify_payment');

Route::get('/test-mail-dispatch', function () {
    $details = [
        'title' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp'
    ];
    $to = request()->query('to', 'godwintumuhimbise96@gmail.com');
    $sent = Mail::to($to)->send(new \App\Mail\TestMail($details));
    if ($sent) {
        return "Email sent successfully";
    } else {
        return "Email not sent";
    }
});



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/userregister', [UserRegister::class, 'index'])->name('userRegister');
    Route::get('/userdetails', [UserRegister::class, 'userDetails'])->name('userDetails');
    Route::post('/makeuserbeneficiary', [UserRegister::class, 'makeuserbeneficiary']);
    Route::post('/deactivateBeneficiary', [UserRegister::class, 'deactivateBeneficiary']);
    Route::post('/userbeneficiaryrequest', [UserRegister::class, 'userbeneficiaryrequest']);
    Route::get('/myevents', [EventsController::class, 'myEvents'])->name('my_events_page');
    Route::get('/mymovies', [MoviesController::class, 'myMovies'])->name('my_movies_page');
    Route::get('/schedulemovies', [MoviesController::class, 'schedueMovie'])->name('schedule_movies_page');
    Route::get('/scheduleevents', [EventsController::class, 'ScheduleEvent'])->name('schedule_events_page');
    Route::post('/createevent', [EventsController::class, 'CreateEvent'])->name('create_event');
    Route::post('/createmovie', [MoviesController::class, 'CreateMovie'])->name('create_movie');
    Route::post('/createmoviereview', [MoviesController::class, 'CreateMovieReview'])->name('create_movie_review');
    Route::post('/createeventreview', [EventsController::class, 'CreateEventReview'])->name('create_event_review');
    Route::post('/registerforevent', [EventsController::class, 'RegisterForEvent'])->name('register_for_event');
    Route::get("/movie/{title}/{id}", [MoviesController::class, 'movieDetail'])->name('movie_detail');
    Route::get("/moviemanager/{title}/{id}", [MoviesController::class, 'movieManager'])->name('movie_manager');
    Route::get("/moviemanager/{title}/{id}", [MoviesController::class, 'movieManager'])->name('movie_manager');
    Route::get("/edit_movie/{id}", [MoviesController::class, 'editMovie'])->name('edit_movie');
    Route::get("/delete_movie/{id}", [MoviesController::class, 'deleteMovie'])->name('delete_movie');
    Route::get("/edit_event/{id}", [EventsController::class, 'editEvent'])->name('edit_event');
    Route::get("/delete_event/{id}", [EventsController::class, 'deleteEvent'])->name('delete_event');
    Route::get("/seat-map/{id}", [MoviesController::class, 'seatMap'])->name('seat_map');
    Route::get("/event/{title}/{id}", [EventsController::class, 'eventDetail'])->name('event_detail');
    Route::post("/event/acceptinvitation", [EventsController::class, 'acceptInvitation'])->name('accept_invitation');
    Route::post("/event/declineinvitation", [EventsController::class, 'declineInvitation'])->name('decline_invitation');
    Route::get("/eventmanager/{title}/{id}", [EventsController::class, 'eventManager'])->name('event_manager');
    Route::get("/allevents", [EventsController::class, 'allEvents'])->name('all_events');
    Route::get("/allmovies", [MoviesController::class, 'allMovies'])->name('all_Movies');
    Route::get('/mytransactions', [TransactionsController::class, 'myTransactions'])->name('my_transactions');
    Route::get('/mywallet', [WalletController::class, 'myTransactions'])->name('my_wallet');
    Route::get('/mytickets', [TicketController::class, 'myTickets'])->name('my_tickets');
    Route::post('/saveseatmap', [MoviesController::class, 'saveSeatMap'])->name('save_seat_map');
    Route::post('/deleteseatmap', [MoviesController::class, 'deleteSeatMap'])->name('delete_seat_map');
    Route::get('/activations', [ActivationController::class, 'activationPage'])->name('activations');
    Route::get("/movie/buy-ticket/{title}/{id}", [MoviesController::class, 'buyMovieTicket'])->name('movie_buy_ticket');
    Route::post('/payMovie/wallet', [MoviesController::class, 'walletPay']);
    Route::post('/payEvent/wallet', [EventsController::class, 'walletPay']);







    Route::get('/settings', [SettingsController::class, 'settings'])->name('settings');
    Route::prefix('admin')->group(function () {
        Route::post('/saveeventssettings', [EventsController::class, 'saveEventsSettings'])->name('eventsSettins');
        Route::post('/savemoviessettings', [MoviesController::class, 'savemoviesSettings'])->name('moviesSettins');
        Route::post('/activateEvent', [ActivationController::class, 'activateEvent'])->name('activate_Event');
        Route::post('/deactivateEvent', [ActivationController::class, 'deactivateEvent'])->name('deactivate_Event');
        Route::post('/activateMovie', [ActivationController::class, 'activateMovie'])->name('activate_Movie');
        Route::post('/deactivateMovie', [ActivationController::class, 'deactivateMovie'])->name('deactivate_Movie');

        // get business settings
        Route::get('/get-business-config', [SettingsController::class, 'getBusinessSettings'])->name('get_business_settings');
        // update business settings
        Route::post('/update-business-config', [SettingsController::class, 'updateBusinessSettings'])->name('update_business_settings');
    });
});
