<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MovieSettings;
use App\Http\Requests\CreateMovie;
use App\Services\MovieService;
use App\Models\MovieCategory;
use App\Models\User;

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
        $movieCategories = MovieCategory::select('id', 'name')->get();
        $beneficiaries = User::select('id', 'name')->where('user_type', 'beneficiary')->where('beneficiary_status', 'active')->get();
        return \Inertia\Inertia::render('Movies/ScheduleMovie',[
            'movieCategories' => $movieCategories,
            'beneficiaries' => $beneficiaries
        ]);
    }

    public function CreateMovie(CreateMovie $request){
        $movieDetails = $request->validated();
        MovieService::createMovie($movieDetails);
        return \Inertia\Inertia::render('Movies/MyMovies');
    }

    public function savemoviesSettings(MovieSettings $request)
    {
        $settingsData = $request->validated();
        MovieService::saveSettings($settingsData);
    }
}
