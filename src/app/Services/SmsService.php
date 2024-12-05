<?php

namespace App\Services;

use AfricasTalking\SDK\AfricasTalking;
use AfricasTalking\SDK\SMS;

class SmsService
{
    protected static string $username;
    protected static string $apiKey;
    protected static string $message;
    protected static array|string $recipients;
    protected static string $from;
    protected static SMS $sms;
    protected static bool $bulk = false;

    /**
     * Create a new instance of the SMS Service to send a single message
     *
     * 
     * Usage: SmsService::single()->message('Welcome to FrontRow')->to('256774000000')->send();
     * 
     * @return SmsService
     */
    public static function single()
    {

        self::$username = env('AFT_USERNAME', '');
        self::$apiKey = env('AFT_API_KEY', '');
        self::$from = env('AFT_FROM', '');

        if (!self::$username || !self::$apiKey || !self::$from) {
            throw new \Exception('Africastalking credentials are not set. Please set them in the .env file');
        }
        self::$bulk = false;
        $aft = new AfricasTalking(self::$username, self::$apiKey);
        self::$sms = $aft->sms();
        return new self();
    }

    /**
     * Create a new instance of the SMS Service to send bulk messages
     *
     * Usage: SmsService::bulk()->message('Welcome to the FrontRow')->to(['256774000000', '256774000001'])->send();
     * @return SmsService
     */
    public static function bulk()
    {

        self::$bulk = true;
        self::$username = env('AFT_USERNAME');
        self::$apiKey = env('AFT_API_KEY');
        self::$from = env('AFT_FROM');

        if (!self::$username || !self::$apiKey || !self::$from) {
            throw new \Exception('Africastalking credentials are not set. Please set them in the .env file');
        }
        $aft = new AfricasTalking(self::$username, self::$apiKey);
        self::$sms = $aft->sms();
        return new self();
    }

    /**
     * Set the message to be sent
     *
     * @param string $message
     * @return SmsService
     */
    public function message(string $message)
    {
        self::$message = $message;
        return $this;
    }

    /**
     * Set the receiver(s) of the message
     * 
     * @param array|string $recipients
     * @return SmsService
     */
    public function to(array|string $recipients)
    {
        // if bulk is set to true, then the recipients should be an array
        if (self::$bulk && !is_array($recipients)) {
            throw new \Exception('Recipients should be an array when sending bulk messages');
        }
        // if bulk is set to false, then the recipients should be a string
        if (!self::$bulk && is_array($recipients)) {
            throw new \Exception('Recipients should be a string when sending single messages');
        }

        if (is_array($recipients)) {
            $recipients = implode(',', $recipients);
        }

        self::$recipients = $recipients;
        return $this;
    }

    /**
     * Send the message
     *
     * @return mixed
     * 
     * @throws \Throwable
     */
    public function send()
    {
        try {
            $options = [
                'to' => self::$recipients,
                'message' => self::$message,
                'from' => self::$from
            ];
            $response = self::$sms->send($options);

            return $response;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}