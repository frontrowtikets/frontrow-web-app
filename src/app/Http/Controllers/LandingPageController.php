<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Event;
use App\Models\Movie;
use App\Models\BannerImage;
use Carbon\Carbon;


class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        // Cache banner images for 1 hour (rarely changes)
        $bannerImages = Cache::remember('landing_banner_images', 3600, function () {
            return BannerImage::select('id', 'path')->limit(10)->get()->map(function ($image) {
                return [
                    'url' => asset('storage/' . $image->path)
                ];
            });
        });

        // Select only needed columns and limit eager-loaded ticket fields
        $last3Movies = Movie::where('is_active', true)
            ->select('id', 'title', 'thumbnail_url', 'description', 'created_at')
            ->with(["showTimes" => function ($query) {
                $query->where('screening_date', '>=', Carbon::now())
                    ->select('id', 'movie_id', 'screening_date', 'screening_time');
            }])
            ->whereHas('showTimes', function ($query) {
                $query->where('screening_date', '>=', Carbon::now());
            })->latest()->take(3)->get();

        $last3Events = Event::where('is_active', true)
            ->where('end_date', '>=', now())
            ->select('id', 'title', 'thumbnail_url', 'banner_image_url', 'start_date', 'end_date', 'location_name', 'created_at')
            ->with(["eventTickets:id,event_id,category,price,currency"])
            ->latest()->take(3)->get();

        $upcomingmovies = Movie::where('is_active', true)
            ->select('id', 'title', 'thumbnail_url', 'description', 'created_at')
            ->with(['showTimes' => function ($query) {
                $query->where('screening_date', '>=', now())
                    ->orderBy('screening_date', 'asc')
                    ->select('id', 'movie_id', 'screening_date', 'screening_time');
            }])
            ->whereHas('showTimes', function ($query) {
                $query->where('screening_date', '>=', now());
            })
            ->take(3)
            ->get();

        $upcomingevents = Event::where('is_active', true)
            ->select('id', 'title', 'thumbnail_url', 'banner_image_url', 'start_date', 'end_date', 'location_name', 'created_at')
            ->with(['eventTickets:id,event_id,category,price,currency'])
            ->where('start_date', '>=', now())
            ->orderBy('start_date', 'asc')
            ->take(3)
            ->get();

        return \Inertia\Inertia::render('LandingPage', [
            'last3Movies' => $last3Movies,
            'last3Events' => $last3Events,
            'upcomingmovies' => $upcomingmovies,
            'upcomingevents' => $upcomingevents,
            'bannerImages' => $bannerImages
        ]);
    }
}
