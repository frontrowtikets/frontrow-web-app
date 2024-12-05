<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserRegister extends Controller
{
    public function index()
    {

        $users = User::get();
        return   \Inertia\Inertia::render('UserRegister/Users', [
            'users' => $users,
        ]);
    }

    public function userDetails(Request $request)
    {
        $user = User::where('id', $request->userID)->first();
        return   \Inertia\Inertia::render('UserRegister/UserDetails', [
            'userDetails' => $user,
        ]);
    }
}
