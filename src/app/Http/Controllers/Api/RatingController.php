<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MovieRating;

class RatingController extends Controller
{
    public function saveRating(Request $request)
    {
        MovieRating::create([
            'movie_id' => $request->movieId,
            'rating'  => $request->rating,
        ]);
    }
}
