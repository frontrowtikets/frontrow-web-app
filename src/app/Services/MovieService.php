<?php

namespace App\Services;

use App\Models\MovieCategory;
use App\Models\Movie;
use Illuminate\Support\Facades\Auth;
use App\Models\MovieCategoryLink;
use App\Models\MovieShowTime;


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

    public static function createMovie($movieDetails){

        $createdMovie = Movie::updateOrCreate([
            'id' => isset($movieDetails['id']) ? $movieDetails['id'] : null
        ],[
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

        $cardImage = $createdMovie->addMedia($movieDetails['cardImage'])->toMediaCollection('event_images');
        $cardImageUrl = $cardImage->getUrl();
        $createdMovie->thumbnail_url = $cardImageUrl;

        if (isset($movieDetails['bannerImage'])) {
            $bannerImage = $createdMovie->addMedia($movieDetails['bannerImage'])->toMediaCollection('event_images');
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

    }
}
