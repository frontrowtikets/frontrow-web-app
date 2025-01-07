<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MovieTicket;
use App\Models\UserEventTicket;
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
        ])->orderBy('created_at', 'desc')->paginate(6);

        $eventTickets = UserEventTicket::where('user_email', Auth::user()->email)->with([
            "event",
            "userPaymentDetail",
            "paymentTransaction"
        ])->orderBy('created_at', 'desc')->paginate(6);

        return \Inertia\Inertia::render('Tickets/MyTickets', [
            "movieTickets" => $movieTickets,
            "eventTickets" => $eventTickets,
        ]);
    }
}
