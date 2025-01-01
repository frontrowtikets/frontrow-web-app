<?php

namespace App\Services;

use App\Models\MovieCategory;
use App\Models\Movie;
use Illuminate\Support\Facades\Auth;
use App\Models\MovieCategoryLink;
use App\Models\MovieShowTime;
use App\Models\MovieRating;
use App\Models\MovieReview;
use App\Models\SeatMap;
use App\Models\MovieShowTimeSeat;
use App\Models\MovieCast;
use Illuminate\Support\Facades\Log;

/**
 * Event Service.
 * This class is responsible for handing all functionalities related to events
 */
class MovieService
{

    public function __construct() {}

    /**
     * Saving Events Settings
     */
    public static function saveSettings(array $settingsDetails)
    {

        //event categories
        MovieCategory::truncate();
        foreach ($settingsDetails['movieCategories'] as $category) {
            MovieCategory::create([
                'name' => $category
            ]);
        }
    }

    public static function createMovie($movieDetails)
    {

        $createdMovie = Movie::updateOrCreate([
            'id' => isset($movieDetails['id']) ? $movieDetails['id'] : null
        ], [
            'beneficiary_id' => isset($movieDetails['beneficiary_id']) && !is_null($movieDetails['beneficiary_id']) ? $movieDetails['beneficiary_id']  :  Auth::user()->id,
            'title' => $movieDetails['title'],
            'description' => $movieDetails['description'],
            'release_date' => $movieDetails['release_date'],
            'duration' => $movieDetails['duration'],
            'languange' => $movieDetails['language'],
            'trailer_url' => $movieDetails['trailer_url'],
            'status' => $movieDetails['status'],
            'maturity_rating' => $movieDetails['maturity_rating'],
        ]);

        $cardImage = $createdMovie->addMedia($movieDetails['cardImage'])->toMediaCollection('movie_images');
        $cardImageUrl = $cardImage->getUrl();
        $createdMovie->thumbnail_url = $cardImageUrl;

        if (isset($movieDetails['bannerImage'])) {
            $bannerImage = $createdMovie->addMedia($movieDetails['bannerImage'])->toMediaCollection('movie_images');
            $bannerImageUrl = $bannerImage->getUrl();
            $createdMovie->poster_url = $bannerImageUrl;
        }
        $createdMovie->save();

        if (count($movieDetails['categories']) > 0) {
            MovieCategoryLink::where('movie_id', $createdMovie->id)->delete();
            foreach ($movieDetails['categories'] as $category) {
                MovieCategoryLink::create([
                    'movie_id' => $createdMovie->id,
                    'category_id' => $category['id'],
                ]);
            }
        }

        if (count($movieDetails['tickets']) > 0) {
            foreach ($movieDetails['tickets'] as $ticket) {
                MovieShowTime::updateOrCreate(['id' => isset($ticket['id']) ? $ticket['id'] : null], [
                    'movie_id' => $createdMovie->id,
                    'theatre' => $ticket['theatre'],
                    'screening_date' => $ticket['screening_date'],
                    'start_time' => $ticket['start_time'],
                    'end_time' => $ticket['end_time'],
                    'currency' => $ticket['currency'],
                    'ticket_price' => $ticket['ticket_price'],
                ]);
            }
        }

        if (count($movieDetails['casts']) > 0) {
            foreach ($movieDetails['casts'] as $cast) {
               $moviecast = MovieCast::updateOrCreate(['id' => isset($cast['id']) ? $cast['id'] : null],[
                    'movie_id' => $createdMovie->id,
                    'name' => $cast['castName'],
                    'role' => $cast['role'],
                ]);

                if (isset($cast['image']) && !is_null($cast['image']) && $cast['image'] != 'null') {
                    $castImage = $createdMovie->addMedia($cast['image'])->toMediaCollection('casts_profile_images');
                    $castImageUrl = $castImage->getUrl();
                    $moviecast->profile_image_url = $castImageUrl;
                }
                $moviecast->save();
            }
        }

        MovieRating::create([
            'movie_id' => $createdMovie->id,
            'user_id' => $createdMovie->beneficiary_id,
            'rating' => $movieDetails['rating'],
        ]);
    }

    public static function saveSeatMap($seatmapDetails)
    {
        foreach ($seatmapDetails as $seatmapDetail) {

            $seatMapId = null;

            if (array_key_exists('seatmapId', $seatmapDetail) && !is_null($seatmapDetail['seatmapId']) && $seatmapDetail['seatmapId'] != "null") {
                $seatMapId = $seatmapDetail['seatmapId'];
            }

            $createdSeatMap = SeatMap::updateOrCreate([
                'id' => $seatMapId
            ], [
                'movie_id' => $seatmapDetail['showTime']['movie_id'],
                'movie_show_time_id' => $seatmapDetail['showTime']['id'],
                'room_name' => $seatmapDetail['roomName'],
            ]);

            MovieShowTimeSeat::where('seat_map_id', $createdSeatMap->id)->forceDelete();

            foreach ($seatmapDetail['combinations'] as $seatLabel) {


                MovieShowTimeSeat::create([
                    'movie_show_time_id' => $seatmapDetail['showTime']['id'],
                    'seat_map_id' => $createdSeatMap->id,
                    'seat_number' => $seatLabel['label'],
                    'seat_status' => in_array($seatLabel['label'], $seatmapDetail['reserved']) ? 'reserved' : 'available',
                ]);
            }
        }
    }

    public static function deleteSeatMap($seatMapId){
        SeatMap::where('id', $seatMapId)->forceDelete();
    }

    public static function createReview($reviewDetails)
    {
        MovieReview::create([
            'movie_id' => $reviewDetails['movie_id'],
            'user_id' => $reviewDetails['user_id'],
            'review' => $reviewDetails['review'],
            'submitted_by' => $reviewDetails['submitted_by']
        ]);
    }
}
