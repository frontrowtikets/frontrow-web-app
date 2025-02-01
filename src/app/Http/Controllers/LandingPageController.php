<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Movie;
use App\Models\BannerImage;
use Carbon\Carbon;


class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        $last3Movies = Movie::where('is_active', true)->with(["showTimes" => function ($query) {
            $query->where('screening_date', '>=', Carbon::now());
        }])
            ->whereHas('showTimes', function ($query) {
                $query->where('screening_date', '>=', Carbon::now());
            })->latest()->take(3)->get();
        $last3Events = Event::where('is_active', true)->where('end_date', '>=', now())->with(["eventTickets"])->latest()->take(3)->get();

        $upcomingmovies = Movie::where('is_active', true)->with(['showTimes' => function ($query) {
            $query->where('screening_date', '>=', now())
                ->orderBy('screening_date', 'asc');
        }])
            ->whereHas('showTimes', function ($query) {
                $query->where('screening_date', '>=', now());
            })
            ->take(3)
            ->get();

        $upcomingevents = Event::where('is_active', true)->with(['eventTickets'])
            ->where('start_date', '>=', now())
            ->orderBy('start_date', 'asc')
            ->take(3)
            ->get();

        $bannerImages = BannerImage::all()->map(function ($image) {
            return [
                'url' => asset('storage/' . $image->path)
            ];
        });

        return \Inertia\Inertia::render('LandingPage', [
            'last3Movies' => $last3Movies,
            'last3Events' => $last3Events,
            'upcomingmovies' => $upcomingmovies,
            'upcomingevents' => $upcomingevents,
            'bannerImages' => $bannerImages
        ]);


    }
}
