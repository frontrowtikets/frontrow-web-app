<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function myTransactions(Request $request){
        return \Inertia\Inertia::render('Wallet/MyWallet');

    }
}
