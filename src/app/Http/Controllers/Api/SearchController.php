<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Movie;
use Carbon\Carbon;


class SearchController extends Controller
{
    public function searchItem(Request $request)
    {
        $searchItem = $request->searchVal;
        $events = Event::where('is_active', true)
            ->where('end_date', '>=', now())
            ->where('title', 'ILIKE', "%{$searchItem}%")
            ->orWhere('description', 'ILIKE', "%{$searchItem}%")
            ->orWhere('location_name', 'ILIKE', "%{$searchItem}%")
            ->with(["eventTickets"])->orderBy('created_at', 'desc')->get();

        $movies = Movie::where('is_active', true)
            ->where('title', 'ILIKE', "%{$searchItem}%")
            ->orWhere('description', 'ILIKE', "%{$searchItem}%")
            ->orWhere('director', 'ILIKE', "%{$searchItem}%")
            ->orWhere('writer', 'ILIKE', "%{$searchItem}%")
            ->orWhere('producer', 'ILIKE', "%{$searchItem}%")
            ->with(["showTimes" => function ($query) {
                $query->where('screening_date', '>=', Carbon::now());
            }])
            ->whereHas('showTimes', function ($query) {
                $query->where('screening_date', '>=', Carbon::now());
            })
            ->orderBy('created_at', 'desc')->get();

        $searchResults = [
            'events' => $events,
            'movies' => $movies
        ];

        return apiResponse($searchResults);
    }
}
