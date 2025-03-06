<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SearchController extends Controller
{
    public function search(Request $request)
    {
        if (Auth::check()) {
            return \Inertia\Inertia::render('Search/SearchPage', [
            ]);
        } else {
            return \Inertia\Inertia::render(
                'Search/SearchPageHome',
                []
            );
        }
    }

    // public function searchItem(Request $request){
    //     $searchItem = $request->searchText;

    //     return $searchItem;
    // }
}
