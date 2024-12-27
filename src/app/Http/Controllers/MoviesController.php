<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MovieSettings;
use App\Http\Requests\CreateMovie;
use App\Http\Requests\CreateMovieReview;
use App\Services\MovieService;
use App\Models\MovieCategory;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MoviesController extends Controller
{
    public function homeMovies(Request $request)
    {
        return \Inertia\Inertia::render('Movies/MoviesHomePage');
    }

    public function myMovies(Request $request)
    {
        $myMovies = Movie::where('beneficiary_id', Auth::id())->latest()->paginate(12);
        return \Inertia\Inertia::render('Movies/MyMovies', [
            'userMovies' => $myMovies
        ]);
    }

    public function schedueMovie(Request $request)
    {
        $movieCategories = MovieCategory::select('id', 'name')->get();
        $beneficiaries = User::select('id', 'name')->where('user_type', 'beneficiary')->where('beneficiary_status', 'active')->get();
        return \Inertia\Inertia::render('Movies/ScheduleMovie', [
            'movieCategories' => $movieCategories,
            'beneficiaries' => $beneficiaries
        ]);
    }

    public function CreateMovie(CreateMovie $request)
    {
        $movieDetails = $request->validated();
        MovieService::createMovie($movieDetails);
        return \Inertia\Inertia::render('Movies/MyMovies');
    }

    public function CreateMovieReview(CreateMovieReview $request)
    {
        $reviewDetails = $request->validated();
        MovieService::createReview($reviewDetails);
    }

    public function movieDetail(Request $request)
    {
        $movieDetail = Movie::where('id', $request->id)->with([
            'beneficiary',
            'showTimes',
            'genres',
            'reviews.user'
        ])->first();
        return \Inertia\Inertia::render('Movies/MovieDetailsPage', [
            'movieDetails' => $movieDetail
        ]);
    }

    public function buyMovieTicket(Request $request)
    {
        $movieDetail = Movie::where('id', $request->id)->with([
            'showTimes',
        ])->first();
        return \Inertia\Inertia::render('Movies/BuyMovieTicket', [
            'buyMovieDetails' => $movieDetail
        ]);
    }

    public function saveSeatMap(Request $request)
    {
        $seatMapDetails = $request->seatMaps;
        MovieService::saveSeatMap($seatMapDetails);
    }

    public function movieManager(Request $request){
        return \Inertia\Inertia::render('Movies/MovieManager', );
    }

    public function allMovies(Request $request){
        $movies = Movie::orderBy('created_at', 'desc')->paginate(12);
        return \Inertia\Inertia::render('Movies/AllMoviesPage', [
            'movies' => $movies
        ]);
    }

    public function seatMap(Request $request){
        $movieDetails = Movie::select('id', 'title')->where('id',$request->id)->with([
            'showTimes',
            'genres',
        ])->first();
        return \Inertia\Inertia::render('Movies/MovieSeatMap', [
            'movieDetails' => $movieDetails
        ]);
    }

    public function savemoviesSettings(MovieSettings $request)
    {
        $settingsData = $request->validated();
        MovieService::saveSettings($settingsData);
    }
}
