<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeductServiceFee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deduct-service-fee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deduct service fee from successful transactions and credit shareholder wallet if set';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        // fetch all successful transactions that have not been deducted service fee
        $transactions = \App\Models\PaymentTransaction::where('status', 'successful')
            ->whereDoesntHave('serviceFeeDeduction')
            ->get();

        // set service fee 
        $serviceFee = \App\Models\BusinessSetting::first()->service_fee;

        // get shareholder_wallet_id from business settings
        $shareholderWalletId = \App\Models\BusinessSetting::first()->shareholder_wallet_id;

        // deduct service fee from each transaction and save the deduction
        foreach ($transactions as $transaction) {
            // if shareholder_wallet_id is set, credit the shareholder wallet
            if ($shareholderWalletId) {
                $wallet = \App\Models\UserWallet::find($shareholderWalletId);
                // if wallet is found, credit the wallet
                if ($wallet) {
                    $wallet->balance += $serviceFee;
                    $wallet->save();

                    // save the deduction
                    $deduction = new \App\Models\ServiceFeeDeduction();
                    $deduction->payment_transaction_id = $transaction->id;
                    $deduction->amount = $serviceFee;
                    $deduction->save();
                }
            }
        }
    }
}
