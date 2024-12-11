<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventCategory;
use App\Models\MovieCategory;

class SettingsController extends Controller
{
    public function settings(Request $request){
        $eventCategories = EventCategory::pluck("name")->toArray();
        $movieCategories = MovieCategory::pluck("name")->toArray();
        return \Inertia\Inertia::render('SettingsPage',[
            'eventCategories' => $eventCategories,
            'movieCategories' => $movieCategories
        ]);

    }
}
