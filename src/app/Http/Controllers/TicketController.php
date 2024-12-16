<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function myTickets(Request $request){
        return \Inertia\Inertia::render('Tickets/MyTickets');
    }
}
