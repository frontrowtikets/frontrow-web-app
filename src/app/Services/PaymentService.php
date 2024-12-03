<?php

namespace App\Services;

use App\Models\PaymentTransaction;
use Beyonic;
use Beyonic_Collection_Request;
use Beyonic_Exception;
use App\Services\WalletService;
use App\Models\User;

/**
 * Payment Service
 * 
 * This class is responsible for handling all payment transactions
 * 
 * Usage:
 * Collect Payment: PaymentService::collect(60000, '0782033409', $user)->max_attempts(2)->pay();
 * 
 * Topup Wallet: PaymentService::wallet(60000, '0782033409', $user)->max_attempts(1)->deposit();
 */
class PaymentService
{
    //

    protected static $collection_intent = array();
    protected static $max_attempts = 3;
    protected static $is_wallet = false;
    protected static $collection_prams = array();

    /**
     * Number to attempts to retry collecting the payments in case of failure
     *
     * @param integer $attempts
     */
    public function max_attempts(int $attempts = 3)
    {
        self::$max_attempts = $attempts;
        return $this;
    }


    /**
     * Log the transaction and proceed with the request
     *
     * @param object $param collection request object
     * 
     * @return bool
     */
    protected function logTransaction($param)
    {
        $collection = [
            'txn_ref' => $param->id,
            'mfscode' => $param->mfs_code,
            'txn_type' => $param->metadata->txn_type,
            'txn_status' => $param->status,
            'amount' => $param->amount,
            'currency' => $param->currency,
            'reason' => $param->reason,
            'phone_number' => $param->phone_number,
            'user_id' => $param->metadata->user_id,
            'txn_hash' => $param->metadata->txn_hash
        ];

        if ($param->status !== 'pending') {
            return false;
        }

        $log = new PaymentTransaction($collection);
        return $log->save();
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
     * Initiate a payment
     *
     * @param integer $amount
     * @param string $phone
     * @param User $user
     * @param $meta default ['prefix' => '256', 'txn_channel' => 'web']
     */
    public static function wallet(int $amount, string $phone, User $user, $meta = ['prefix' => '256', 'txn_channel' => 'web'])
    {
        self::$is_wallet = true;
        $has_leading_zero = substr($phone, 0, 1) === '0' ? true : false;
        $phone_len =  strlen($phone);

        $prefix = $meta['prefix'];

        if ($phone_len === 10 && $has_leading_zero) {
            $phone = substr($phone, 1);
            $phone = "+" . $prefix . $phone;
        } elseif ($phone_len < 10 && !$has_leading_zero) {
            $phone = "+" . $prefix . $phone;
        } // phone begins with a + sign
        elseif ($phone_len === 13 && substr($phone, 0, 1) === '+') {
            $phone = $phone;
        } else {
            $phone = "+"  . $phone;
        }
        self::$collection_prams = [
            'phone' => $phone,
            'amount' => $amount,
            'user' => $user,
            'meta' => $meta,
        ];

        self::setCollectionObject();

        return new WalletService(self::$collection_intent);
    }


    /**
     * Begin Transaction processing
     *
     * @return bool|string
     */
    public function pay()
    {
        try {
            self::setCollectionObject();

            $this->setApiKey();
            dd(self::$collection_intent);
            $payment = (object) Beyonic_Collection_Request::create(self::$collection_intent);
            return self::logTransaction($payment);
        } catch (Beyonic_Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Initiate a payment
     *
     * @param integer $amount
     * @param string $phone
     * @param User $user
     * @param $meta default ['prefix' => '256', 'txn_channel' => 'web']
     * 
     * @return this
     */
    public static function collect(int $amount, string $phone, User $user, array $meta = ['prefix' => '256', 'txn_channel' => 'web'])
    {

        $has_leading_zero = substr($phone, 0, 1) === '0' ? true : false;

        $phone_len =  strlen($phone);

        $prefix = $meta['prefix'];

        if ($phone_len === 10 && $has_leading_zero) {
            $phone = substr($phone, 1);
            $phone = "+" . $prefix . $phone;
        } elseif ($phone_len < 10 && !$has_leading_zero) {
            $phone = "+" . $prefix . $phone;
        } // phone begins with a + sign
        elseif ($phone_len === 13 && substr($phone, 0, 1) === '+') {
            $phone = $phone;
        } else {
            $phone = "+"  . $phone;
        }

        self::$collection_prams = [
            'phone' => $phone,
            'amount' => $amount,
            'user' => $user,
            'meta' => $meta,
        ];

        return new self;
    }


    private static function setCollectionObject()
    {
        $phone = self::$collection_prams['phone'];
        $amount = self::$collection_prams['amount'];
        $user = self::$collection_prams['user'];
        $name = explode(" ", $user->name);

        $metadata = [
            'txn_type' => self::$is_wallet ? 'wallet_topup' : 'ticket_purchase',
            'user_id' => $user->id,
            'txn_hash' => md5($phone . $amount . $user->id)
        ];

        array_push($metadata, self::$collection_prams['meta']);

        $collection =   [
            "phonenumber" => $phone,
            "amount" => $amount,
            "first_name" => isset($name[0]) ? $name[0] : $user->name,
            "last_name" => isset($name[1]) ? $name[1] : $user->name,
            "currency" => "UGX",
            "reason" => self::$is_wallet ? "Wallet Topup" : "Ticket Purchase",
            "metadata" => $metadata,
            "send_instructions" => True,
            "max_attempts" => self::$max_attempts
        ];

        self::$collection_intent = $collection;
    }
}