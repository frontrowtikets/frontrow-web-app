<?php

namespace App\Services;

use App\Models\EventCategory;

/**
 * Event Service.
 * This class is responsible for handing all functionalities related to events
 */
class EventService
{

    public function __construct() {}

    /**
     * Saving Events Settings
     */
    public static function saveSettings(array $settingsDetails)
    {

        //event categories
        EventCategory::truncate();
        foreach ($settingsDetails['eventCategories'] as $category) {
            EventCategory::create([
                'name' => $category
            ]);
        }
    }
}
