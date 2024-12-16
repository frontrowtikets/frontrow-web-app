<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserRegister;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::get('/events', [EventsController::class, 'homeEvents'])->name('events_home_page');
Route::get('/movies', [MoviesController::class, 'homeMovies'])->name('events_home_page');




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
    Route::get("/movie/{title}/{id}", [MoviesController::class, 'movieDetail'])->name('movie_detail');
    Route::get("/movie/buy-ticket/{title}/{id}", [MoviesController::class, 'buyMovieTicket'])->name('movie_buy_ticket');

    Route::get('/settings', [SettingsController::class, 'settings'])->name('settings');
    Route::prefix('admin')->group(function () {
        Route::post('/saveeventssettings', [EventsController::class, 'saveEventsSettings'])->name('eventsSettins');
        Route::post('/savemoviessettings', [MoviesController::class, 'savemoviesSettings'])->name('moviesSettins');
    });
});

