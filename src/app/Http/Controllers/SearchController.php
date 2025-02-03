<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SearchController extends Controller
{
    public function search()
    {
        if (Auth::check()) {
            return \Inertia\Inertia::render('Search/SearchPage', []);
        } else {
            return \Inertia\Inertia::render(
                'Search/SearchPageHome',
                []
            );
        }
    }
}
