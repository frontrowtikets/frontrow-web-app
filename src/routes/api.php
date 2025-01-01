<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserRegister;
use App\Http\Controllers\Api\v1\BuyEventTicketController;
use App\Http\Controllers\Api\v1\BuyMovieTicketController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['namespace' => 'Api'], function () {

    Route::post('/v1/buyMovieTicket', [BuyMovieTicketController::class, 'buyTicket']);
    Route::post('/v1/buyEventTicket', [BuyEventTicketController::class, 'buyTicket']);


    Route::group(['middleware' => [
        'auth:sanctum'

    ]], function () {
        Route::prefix('userRegister')->group(function () {
            Route::post("/revokePermission", [UserRegister::class, 'revokePermission']);
            Route::post("/assignPermissions", [UserRegister::class, 'assignPermissions']);
        });
    });
});
