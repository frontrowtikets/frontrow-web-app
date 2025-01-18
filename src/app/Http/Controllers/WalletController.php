<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\Auth;


class WalletController extends Controller
{
    public function myTransactions(Request $request){


        $transactions = PaymentTransaction::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->take(12)->get();

        return \Inertia\Inertia::render('Wallet/MyWallet',[
            'transactions' => $transactions
        ]);
    }
}
