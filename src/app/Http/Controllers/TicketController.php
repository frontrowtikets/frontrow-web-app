<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MovieTicket;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function myTickets(Request $request)
    {

        $movieTickets = MovieTicket::where('user_email', Auth::user()->email)->with([
            'movie',
            'userPaymentDetail',
            'paymentTransaction',
            'theatre',
            "showTimeSeats",
             "showTimeSeats.seatmap"
        ])->get();

        return \Inertia\Inertia::render('Tickets/MyTickets', [
            "movieTickets" => $movieTickets
        ]);
    }
}
