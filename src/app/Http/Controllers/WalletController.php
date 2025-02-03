<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\Auth;
use App\Models\UserWallet;
use Illuminate\Support\Facades\Mail;
use App\Mail\WalletDepostMail;
use App\Models\User;


class WalletController extends Controller
{
    public function myTransactions(Request $request){


        $transactions = PaymentTransaction::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->take(12)->get();
        $myWallet = UserWallet::where('user_id', Auth::user()->id)->first();

        return \Inertia\Inertia::render('Wallet/MyWallet',[
            'transactions' => $transactions,
            'myWallet' => $myWallet
        ]);
    }
     public function topUp($paymentDetails){

        $walletDetails = UserWallet::where('user_id', $paymentDetails['userId'])->first();
        $currentUser = User::where('id', Auth::user()->id)->first();

        if(is_null($walletDetails)){
            UserWallet::create([
                'user_id' => $paymentDetails['userId'],
                'balance' => $paymentDetails['amount']
            ]);
        }else{
            $walletDetails->balance= $walletDetails->balance + $paymentDetails['amount'];
            $walletDetails->save();
        }

        $paymentTransactions = PaymentTransaction::create([
            'txn_ref' => $paymentDetails['merchant_reference'],
            'mfscode' => $paymentDetails['confirmation_code'],
            'txn_type' => $paymentDetails['purpose'],
            'txn_channel' => 'web',
            'txn_status' => $paymentDetails['status'] == 1 || $paymentDetails['status'] == '1' ? 'paid' : 'failed',
            'amount' => $paymentDetails['total'],
            'currency' => $paymentDetails['currency'],
            'reason' => 'Paying for event tickets',
            'phone_number' => $paymentDetails['phoneNumber'],
            'user_id' => $paymentDetails['userId'],
            'txn_hash' => $paymentDetails['merchant_reference']
        ]);

        try {
            $message = (new WalletDepostMail($currentUser->name, $paymentTransactions->currency, $paymentTransactions->amount))
                ->onQueue('emails');

            Mail::to($currentUser->email)
                ->queue($message);
        } catch (\Throwable $th) {
            //throw $th;
        }


     }
}
