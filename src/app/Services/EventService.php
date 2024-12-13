<?php

namespace App\Services;

use App\Models\EventCategory;
use App\Models\Event;
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

    public static function creteEvent($eventDetails){

        Event::updateOrCreate(['id' => $eventDetails['id']],[
            'beneficiary_id' => $eventDetails[''],
            'title' => $eventDetails[''],
            'description' => $eventDetails[''],
            'location_name' => $eventDetails[''],
            'gps_location' => $eventDetails[''],
            'start_date' => $eventDetails[''],
            'end_date' => $eventDetails[''],
            'thumbnail_url' => $eventDetails[''],
            'currency' => $eventDetails[''],
            'access_type' => $eventDetails[''],
        ]);

    }
}
