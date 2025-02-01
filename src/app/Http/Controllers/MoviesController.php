<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MovieSettings;
use App\Http\Requests\CreateMovie;
use App\Http\Requests\CreateMovieReview;
use App\Services\MovieService;
use App\Models\MovieCategory;
use App\Models\Movie;
use App\Models\MovieTicket;
use App\Models\PaymentTransaction;
use App\Models\User;
use App\Models\UserPaymentDetail;
use Illuminate\Support\Facades\Auth;
use App\Models\UserWallet;
use Carbon\Carbon;


class MoviesController extends Controller
{
    public function homeMovies(Request $request)
    {
        $movies = Movie::where('is_active', true)->with(["showTimes" => function ($query) {
            $query->where('screening_date', '>=', Carbon::now());
        }])
            ->whereHas('showTimes', function ($query) {
                $query->where('screening_date', '>=', Carbon::now());
            })
            ->orderBy('created_at', 'desc')->paginate(6);

        $categories = MovieCategory::get();

        return \Inertia\Inertia::render('Movies/MoviesHomePage', [
            'movies' => $movies,
            'categories' => $categories
        ]);
    }

    public function myMovies(Request $request)
    {
        $myMovies = Movie::where('beneficiary_id', Auth::id())->latest()->paginate(6);
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
            'reviews.user',
            'moviecasts'
        ])->first();
        $myWallet = UserWallet::where('user_id', Auth::user()->id)->first();

        return \Inertia\Inertia::render('Movies/MovieDetailsPage', [
            'movieDetails' => $movieDetail,
            'myWallet' => $myWallet

        ]);
    }

    public function movieDetailHome(Request $request)
    {
        $movieDetail = Movie::where('id', $request->id)->with([
            'beneficiary',
            'showTimes',
            'genres',
            'reviews.user',
            'moviecasts'
        ])->first();

        return \Inertia\Inertia::render('Movies/MovieDetailsHomePage', [
            'movieDetails' => $movieDetail,

        ]);
    }

    public function buyMovieTicket(Request $request)
    {
        $movieDetail = Movie::where('id', $request->id)->with([
            'showTimes',
            'seatmap',
        ])->first();
        $myWallet = UserWallet::where('user_id', Auth::user()->id)->first();
        return \Inertia\Inertia::render('Movies/BuyMovieTicket', [
            'buyMovieDetails' => $movieDetail,
            'myWallet' => $myWallet
        ]);
    }

    public function buyMovieTicketHome(Request $request)
    {
        $movieDetail = Movie::where('id', $request->id)->with([
            'showTimes',
            'seatmap',
        ])->first();
        return \Inertia\Inertia::render('Movies/BuyMovieTicketHome', [
            'buyMovieDetails' => $movieDetail
        ]);
    }

    public function saveSeatMap(Request $request)
    {
        $seatMapDetails = $request->seatMaps;
        MovieService::saveSeatMap($seatMapDetails);
    }

    public function deleteSeatMap(Request $request)
    {
        $seatMapId = $request->id;
        MovieService::deleteSeatMap($seatMapId);
    }

    public function movieManager(Request $request)
    {
        $movieTickets = MovieTicket::where('movie_id', $request->id)->with([
            'movie',
            'userPaymentDetail',
            'paymentTransaction',
            'theatre',
            "showTimeSeats",
            "showTimeSeats.seatmap"
        ])->orderBy('created_at', 'desc')->paginate(6);
        return \Inertia\Inertia::render(
            'Movies/MovieManager',
            ['movieTickets' => $movieTickets]
        );
    }

    public function allMovies(Request $request)
    {
        $movies = Movie::where('is_active', true)->with(["showTimes" => function ($query) {
            $query->where('screening_date', '>=', Carbon::now());
        }])
            ->whereHas('showTimes', function ($query) {
                $query->where('screening_date', '>=', Carbon::now());
            })->orderBy('created_at', 'desc')->paginate(6);
        return \Inertia\Inertia::render('Movies/AllMoviesPage', [
            'movies' => $movies
        ]);
    }

    public function seatMap(Request $request)
    {
        $movieDetails = Movie::select('id', 'title')->where('id', $request->id)->with([
            'showTimes',
            'genres',
            'seatmap'
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

    public function verifyTicket(Request $request)
    {
        $movieTikectDetails = MovieTicket::where('ticket_id', $request->ticketId)->where('user_payment_detail_id', $request->userDetailsId)->where('payment_transaction_id', $request->transactionId)->with([
            'movie',
            'theatre',
            "showTimeSeats",
            "showTimeSeats.seatmap"
        ])->first();
        $userDetails = UserPaymentDetail::where('id', $request->userDetailsId)->first();
        $transactionDetails = PaymentTransaction::where('id', $request->transactionId)->first();

        $isValid = !is_null($movieTikectDetails) && !is_null($userDetails) && !is_null($transactionDetails);

        return \Inertia\Inertia::render('Movies/VerifyMovieTicket', [
            'movieTikectDetails' => $movieTikectDetails,
            'userDetails' => $userDetails,
            'transactionDetails' => $transactionDetails,
            'isValid' => $isValid

        ]);
    }

    public function editMovie(Request $request)
    {
        $movieDetail = Movie::where('id', $request->id)->with([
            'beneficiary',
            'showTimes',
            'genres',
            'reviews.user',
            'moviecasts'
        ])->first();
        $movieCategories = MovieCategory::select('id', 'name')->get();
        $beneficiaries = User::select('id', 'name')->where('user_type', 'beneficiary')->where('beneficiary_status', 'active')->get();

        return \Inertia\Inertia::render('Movies/ScheduleMovie', [
            'movieCategories' => $movieCategories,
            'beneficiaries' => $beneficiaries,
            'editDetails' => $movieDetail
        ]);
    }

    public function deleteMovie(Request $request)
    {
        $movie = Movie::where('id', $request->id)->first();
        $movie->delete();
    }

    public function walletPay(Request $details)
    {
        MovieService::payWithWallet($details);
    }
}
