<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Movie;
use Illuminate\Http\Request;

class ActivationController extends Controller
{
    public function activationPage()
    {
        $pendingEvents = Event::where('is_active', false)->latest()->paginate(6);
        $pendingMovies = Movie::where('is_active', false)->latest()->paginate(6);
        $activatedEvents = Event::where('is_active', true)->latest()->paginate(6);
        $activatedMovies = Movie::where('is_active', true)->latest()->paginate(6);


        return \Inertia\Inertia::render(
            'Activations/MainActivationPage',
            [
                "pendingEvents" => $pendingEvents,
                "pendingMovies" => $pendingMovies,
                "activatedEvents" => $activatedEvents,
                "activatedMovies" => $activatedMovies
            ]
        );
    }

    public function activateEvent(Request $request)
    {
        $theEvent = Event::where('id', $request->eventId)->first();
        $theEvent->is_active = true;
        $theEvent->save();
    }

    public function deactivateEvent(Request $request)
    {
        $theEvent = Event::where('id', $request->eventId)->first();
        $theEvent->is_active = false;
        $theEvent->save();
    }

    public function activateMovie(Request $request)
    {
        $theMovie = Movie::where('id', $request->movieId)->first();
        $theMovie->is_active = true;
        $theMovie->save();
    }

    public function deactivateMovie(Request $request)
    {
        $theMovie = Movie::where('id', $request->movieId)->first();
        $theMovie->is_active = false;
        $theMovie->save();
    }
}
