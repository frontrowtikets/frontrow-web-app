<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MoviesController extends Controller
{
    public function homeMovies(Request $request)
    {
        return \Inertia\Inertia::render('Movies/MoviesHomePage');
    }

    public function myMovies(Request $request)
    {
        return \Inertia\Inertia::render('Movies/MyMovies');
    }

    public function schedueMovie(Request $request){
        return \Inertia\Inertia::render('Movies/ScheduleMovie');
    }
}
