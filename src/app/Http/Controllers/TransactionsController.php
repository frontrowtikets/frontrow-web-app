<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionsController extends Controller
{
    public function myTransactions(Request $request)
    {
        $transactions = PaymentTransaction::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(6);
        return \Inertia\Inertia::render(
            'Transactions/MyTransactions',
            ["transationDetails" => $transactions]
        );
    }
}
