<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BuyEventTicket;
use App\Services\EventService;


class BuyEventTicketController extends Controller
{
    public function buyTicket(BuyEventTicket $request) {

        $paymentDetails = $request->validated();
        EventService::buyTicket($paymentDetails);
        return response('success');
    }
}
