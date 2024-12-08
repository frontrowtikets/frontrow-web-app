<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserRegister;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['namespace' => 'Api'], function () {

    Route::group(['middleware' => [
        'auth:sanctum'

    ]], function () {
        Route::prefix('userRegister')->group(function () {
            Route::post("/revokePermission", [UserRegister::class, 'revokePermission']);
            Route::post("/assignPermissions", [UserRegister::class, 'assignPermissions']);
        });
    });
});
