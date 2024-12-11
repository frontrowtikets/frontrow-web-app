<?php

namespace App\Services;

use App\Models\MovieCategory;

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
}
