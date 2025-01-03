<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BuyMovieTicket;
use App\Services\MovieService;

class BuyMovieTicketController extends Controller
{
    public function buyTicket(BuyMovieTicket $request){
        $paymentDetails = $request->validated();
        MovieService::buyTicket($paymentDetails);
    }
}
