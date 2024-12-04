<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\EventsPageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserRegister;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::get('/events', [EventsPageController::class, 'index'])->name('events_page');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/userregister', [UserRegister::class, 'index'])->name('userRegister');


});

