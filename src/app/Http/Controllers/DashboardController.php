<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\User;
use App\Models\Incident;

class DashboardController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();
        //check if user has a sanctum token
        $userApiToken = PersonalAccessToken::where('tokenable_id', $user->id)->first();

        // create a  token if the user does not have one already
        $userApiToken = $user->createToken($user->name)->plainTextToken;
        //save the api token on the user's table
        $currentUser = User::where('id', $user->id)->first();
        $currentUser->api_token =  $userApiToken;
        $currentUser->save();

        return Inertia::render('Dashboards/Dashboard', [

        ]);
    }
}
