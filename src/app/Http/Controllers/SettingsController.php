<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventCategory;
use App\Models\MovieCategory;
use \App\Models\BusinessSetting;

class SettingsController extends Controller
{
    public function settings(Request $request)
    {
        $eventCategories = EventCategory::pluck("name")->toArray();
        $movieCategories = MovieCategory::pluck("name")->toArray();
        return \Inertia\Inertia::render('SettingsPage', [
            'eventCategories' => $eventCategories,
            'movieCategories' => $movieCategories
        ]);
    }

    // get business settings and return json response
    public function getBusinessSettings(Request $request)
    {
        $businessSettings = BusinessSetting::with("wallet")->with("wallet.user")->first();
        return response()->json($businessSettings);
    }

    // update business settings
    public function updateBusinessSettings(Request $request)
    {
        $businessSettings = BusinessSetting::first();
        $businessSettings->update($request->all());
    }
}
