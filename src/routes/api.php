<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserRegister;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\v1\BuyEventTicketController;
use App\Http\Controllers\Api\v1\BuyMovieTicketController;
use App\Http\Controllers\Api\v1\PaymentController;
use App\Http\Controllers\Api\BannerImagesController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['namespace' => 'Api'], function () {
    Route::get('/', function () {
        return response()->json(['message' => 'Welcome to the API']);
    });
    Route::post('/v1/buyMovieTicket', [BuyMovieTicketController::class, 'buyTicket']);
    Route::post('/v1/buyEventTicket', [BuyEventTicketController::class, 'buyTicket']);
    Route::post('/rating', [RatingController::class, 'saveRating']);
    Route::post('/v1/collections/initiate', [PaymentController::class, 'initiateCollection']);
    Route::post('/v1/payments/makepayment', [PaymentController::class, 'makePayment']);
    Route::get('/v1/payments/getStatus', [PaymentController::class, 'getPaymentStatus']);





    Route::group(['middleware' => [
        'auth:sanctum'

    ]], function () {
        Route::post("/images", [BannerImagesController::class, 'saveBannerImages']);
        Route::get('/images', [BannerImagesController::class, 'index']);
        Route::delete('/images/{image}', [BannerImagesController::class, 'deleteImage']);

        Route::prefix('userRegister')->group(function () {
            Route::post("/revokePermission", [UserRegister::class, 'revokePermission']);
            Route::post("/assignPermissions", [UserRegister::class, 'assignPermissions']);
        });
    });
});
