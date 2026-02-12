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
            ->where(function ($query) use ($searchItem) {
                $query->where('title', 'ILIKE', "%{$searchItem}%")
                    ->orWhere('description', 'ILIKE', "%{$searchItem}%")
                    ->orWhere('location_name', 'ILIKE', "%{$searchItem}%");
            })
            ->select('id', 'title', 'thumbnail_url', 'start_date', 'end_date', 'location_name', 'access_type', 'created_at')
            ->with(["eventTickets:id,event_id,category,price,currency"])
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        $movies = Movie::where('is_active', true)
            ->where(function ($query) use ($searchItem) {
                $query->where('title', 'ILIKE', "%{$searchItem}%")
                    ->orWhere('description', 'ILIKE', "%{$searchItem}%")
                    ->orWhere('director', 'ILIKE', "%{$searchItem}%")
                    ->orWhere('writer', 'ILIKE', "%{$searchItem}%")
                    ->orWhere('producer', 'ILIKE', "%{$searchItem}%");
            })
            ->select('id', 'title', 'thumbnail_url', 'description', 'created_at')
            ->with(["showTimes" => function ($query) {
                $query->where('screening_date', '>=', Carbon::now())
                    ->select('id', 'movie_id', 'screening_date', 'screening_time');
            }])
            ->whereHas('showTimes', function ($query) {
                $query->where('screening_date', '>=', Carbon::now());
            })
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        $searchResults = [
            'events' => $events,
            'movies' => $movies
        ];

        return apiResponse($searchResults);
    }
}
