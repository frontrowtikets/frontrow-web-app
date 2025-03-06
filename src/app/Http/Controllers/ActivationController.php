<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MovieActivateUserMail;
use App\Mail\EventActivateUserMail;
use App\Mail\EventDeactivateUserMail;
use App\Mail\MovieDeactivateUserMail;
use App\Models\User;

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

        try {
            $currentUser = User::where('id', $theEvent->beneficiary_id)->first();
            $message = (new EventActivateUserMail($currentUser->name, $theEvent->title))
                ->onQueue('emails');

            Mail::to($currentUser->email)
                ->queue($message);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function deactivateEvent(Request $request)
    {
        $theEvent = Event::where('id', $request->eventId)->first();
        $theEvent->is_active = false;
        $theEvent->save();

        try {
            $currentUser = User::where('id', $theEvent->beneficiary_id)->first();
            $message = (new EventDeactivateUserMail($currentUser->name, $theEvent->title))
                ->onQueue('emails');

            Mail::to($currentUser->email)
                ->queue($message);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function activateMovie(Request $request)
    {
        $theMovie = Movie::where('id', $request->movieId)->first();
        $theMovie->is_active = true;
        $theMovie->save();
        try {
            $currentUser = User::where('id', $theMovie->beneficiary_id)->first();
            $message = (new MovieActivateUserMail($currentUser->name, $theMovie->title))
                ->onQueue('emails');

            Mail::to($currentUser->email)
                ->queue($message);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function deactivateMovie(Request $request)
    {
        $theMovie = Movie::where('id', $request->movieId)->first();
        $theMovie->is_active = false;
        $theMovie->save();
        try {
            $currentUser = User::where('id', $theMovie->beneficiary_id)->first();
            $message = (new MovieDeactivateUserMail($currentUser->name, $theMovie->title))
                ->onQueue('emails');

            Mail::to($currentUser->email)
                ->queue($message);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
