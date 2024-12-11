<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EventSettings;
use App\Services\EventService;

class EventsController extends Controller
{


    public function homeEvents(Request $request)
    {
        return \Inertia\Inertia::render('Events/EventsHomePage');
    }

    public function myEvents(Request $request)
    {
        return \Inertia\Inertia::render('Events/MyEvents');
    }

    public function ScheduleEvent(Request $request)
    {
        return \Inertia\Inertia::render('Events/ScheduleEvent');
    }

    public function saveEventsSettings(EventSettings $request)
    {

        $settingsData = $request->validated();
        EventService::saveSettings($settingsData);
    }
}
