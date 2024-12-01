<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\EventsPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::get('/events', [EventsPageController::class, 'index'])->name('events_page');

