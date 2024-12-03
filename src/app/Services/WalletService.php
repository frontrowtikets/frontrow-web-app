<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserWallet;
use Beyonic_Collection_Request;
use Beyonic_Exception;
use App\Models\PaymentTransaction;
use Beyonic;

class WalletService
{

    protected static $collection;

    public function __construct($collection)
    {
        self::$collection = $collection;
    }


    /**
     * Number to attempts to retry collecting the payments in case of failure
     *
     * @param integer $attempts
     */
    public function max_attempts($attempts = 3)
    {
        self::$collection['max_attempts'] = $attempts;
        return $this;
    }

    /**
     * Set the Beyonic client API KEY
     *
     * @return void
     */
    protected function setApiKey()
    {
        $key = env('BEYONIC_API_KEY', 'cd60c22a5371740724e87c61471e576326880d08');

        return Beyonic::setApiKey($key);
    }

    /**
     * Deposit money to wallet
     *
     * @return bool|string
     */
    public function deposit()
    {
        try {
            $this->setApiKey();
            dd(self::$collection);
            $txn = (object) Beyonic_Collection_Request::create(self::$collection);

            $collection = [
                'txn_ref' => $txn->id,
                'mfscode' => $txn->mfs_code,
                'txn_type' => $txn->metadata->txn_type,
                'txn_status' => $txn->status,
                'amount' => $txn->amount,
                'currency' => $txn->currency,
                'reason' => $txn->reason,
                'phone_number' => $txn->phone_number,
                'user_id' => $txn->metadata->user_id,
                'txn_hash' => session()->get('txn_hash'),
                'txn_channel' => $txn->metadata->txn_channel,
                'txn_type' => $txn->metadata->txn_type

            ];

            if ($txn->status !== 'pending') {
                return false;
            }

            $log = new PaymentTransaction($collection);
            return $log->save();
        } catch (Beyonic_Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Deduct money from wallet
     *
     * @param integer $amount
     * @return boolean
     */
    public static function deduct(int $amount, User $user)
    {
        $user_id = $user->id;

        $wallet = UserWallet::where('user_id', $user_id)->first();

        if ($amount > $wallet->balance) {
            return false;
        }

        $balance = $wallet->balance - $amount;

        return UserWallet::where('user_id', $user_id)->update(['balance' => $balance]) > 0;
    }

    /**
     * Top up user wallet
     *
     * @param integer $amount
     * @return boolean
     */
    public static function topUp(int $amount, User $user)
    {
        $user_id = $user->id;

        $wallet = UserWallet::where('user_id', $user_id)->first();

        $amount += $wallet->balance;

        return UserWallet::where('user_id', $user_id)->update(['balance' => $amount]) > 0;
    }
}