<?php

namespace App\Services;

use App\Models\EventCategory;
use App\Models\Event;
use App\Models\EventCategoryLink;
use App\Models\EventTicket;
use Illuminate\Support\Facades\Auth;
use App\Models\EventReview;



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

    public static function creteEvent($eventDetails)
    {

        $createdEvent = Event::updateOrCreate([
            'id' => isset($eventDetails['id']) ? $eventDetails['id'] : null
        ], [
            'beneficiary_id' => isset($eventDetails['beneficiary_id']) ? $eventDetails['beneficiary_id']  :  Auth::user()->id,
            'title' => $eventDetails['title'],
            'description' => $eventDetails['description'],
            'location_name' => $eventDetails['location_name'],
            'gps_location' => $eventDetails['gps_location'],
            'start_date' => $eventDetails['start_date'],
            'start_time' => $eventDetails['start_time'],
            'end_time' => $eventDetails['end_time'],
            'end_date' => $eventDetails['end_date'],
            'access_type' => $eventDetails['access_type'],
            'status' => $eventDetails['status'],
        ]);

        $cardImage = $createdEvent->addMedia($eventDetails['cardImage'])->toMediaCollection('event_images');
        $cardImageUrl = $cardImage->getUrl();
        $createdEvent->thumbnail_url = $cardImageUrl;

        if (isset($eventDetails['bannerImage'])) {
            $bannerImage = $createdEvent->addMedia($eventDetails['bannerImage'])->toMediaCollection('event_images');
            $bannerImageUrl = $bannerImage->getUrl();
            $createdEvent->banner_image_url = $bannerImageUrl;
        }
        $createdEvent->save();

        if (count($eventDetails['categories']) > 0) {
            EventCategoryLink::where('event_id', $createdEvent->id)->delete();
            foreach ($eventDetails['categories'] as $category) {
                EventCategoryLink::create([
                    'event_id' => $createdEvent->id,
                    'category_id' => $category['id'],
                ]);
            }
        }

        if (count($eventDetails['tickets']) > 0) {
            foreach($eventDetails['tickets'] as $ticket){
                EventTicket::updateOrCreate(['id' => isset($ticket['id']) ? $ticket['id'] : null], [
                    'event_id' =>$createdEvent->id,
                    'category' => $ticket['category'],
                    'price' => $ticket['price'],
                    'available_quantity' => $ticket['quantity'],
                    'currency' => $ticket['currency'],
                ]);
            }
        }

    }

    public static function createReview($reviewDetails)
    {
        EventReview::create([
            'event_id' => $reviewDetails['event_id'],
            'user_id' => $reviewDetails['user_id'],
            'review' => $reviewDetails['review'],
            'submitted_by' => $reviewDetails['submitted_by']
        ]);
    }
}
