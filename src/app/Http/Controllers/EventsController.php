<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EventSettings;
use App\Services\EventService;
use App\Models\EventCategory;
use App\Models\User;
use App\Http\Requests\CreateEvent;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;


class EventsController extends Controller
{


    public function homeEvents(Request $request)
    {
        return \Inertia\Inertia::render('Events/EventsHomePage');
    }

    public function myEvents(Request $request)
    {
        $myEvents = Event::where('beneficiary_id', Auth::id())->latest()->paginate(12);
        return \Inertia\Inertia::render('Events/MyEvents',[
            'myEvents' => $myEvents
        ]);
    }

    public function ScheduleEvent(Request $request)
    {
        $eventCategories = EventCategory::select('id', 'name')->get();
        $beneficiaries = User::select('id','name')->where('user_type','beneficiary')->where('beneficiary_status','active')->get();

        return \Inertia\Inertia::render('Events/ScheduleEvent', [
            "eventCategories" => $eventCategories,
            "beneficiaries" => $beneficiaries,
        ]);
    }
    public function CreateEvent(CreateEvent $request){
        $eventDetails = $request->validated();
        EventService::creteEvent($eventDetails);
          return \Inertia\Inertia::render('Events/MyEvents');
    }

    public function saveEventsSettings(EventSettings $request)
    {
        $settingsData = $request->validated();
        EventService::saveSettings($settingsData);
    }
}
