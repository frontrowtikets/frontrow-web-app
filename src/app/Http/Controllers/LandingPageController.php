<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Movie;

class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        $last3Movies = Movie::with(["showTimes"])->latest()->take(3)->get();
        $last3Events = Event::with(["eventTickets"])->latest()->take(3)->get();

        $upcomingmovies = Movie::with(['showTimes' => function ($query) {
            $query->where('screening_date', '>=', now())
                ->orderBy('screening_date', 'asc');
        }])
            ->whereHas('showTimes', function ($query) {
                $query->where('screening_date', '>=', now());
            })
            ->take(3)
            ->get();

        $upcomingevents = Event::with(['eventTickets'])
            ->where('start_date', '>=', now())
            ->orderBy('start_date', 'asc')
            ->take(3)
            ->get();

        return \Inertia\Inertia::render('LandingPage', [
            'last3Movies' => $last3Movies,
            'last3Events' => $last3Events,
            'upcomingmovies' => $upcomingmovies,
            'upcomingevents' => $upcomingevents
        ]);
    }
}
