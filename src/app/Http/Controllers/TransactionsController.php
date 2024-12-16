<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function myTransactions(Request $request){
        return \Inertia\Inertia::render('Transactions/MyTransactions');

    }
}
