<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventsPageController extends Controller
{
    public function index(Request $request){
        return \Inertia\Inertia::render('EventsPage');
    }
}
