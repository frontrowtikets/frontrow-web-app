<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PesapalService
{
    private $consumerKey;
    private $consumerSecret;
    private $baseUrl;
    private $callbackUrl;
    private $ipnUrl;
    private $token;
    private $ipn_id;
    private $notification_id;

    public function __construct()
    {
        $this->consumerKey = config('services.pesapal.consumer_key');
        $this->consumerSecret = config('services.pesapal.consumer_secret');
        $this->baseUrl = config('services.pesapal.base_url');
        $this->callbackUrl = config('services.pesapal.callback_url');
        $this->ipnUrl = config('services.pesapal.ipn_url');
        $this->notification_id = config('services.pesapal.notification_id');

    }

    public function getAuthJWT()
    {
        try {
            $response = Http::timeout(30)
                ->retry(3, 100)
                ->withOptions([
                    'verify' => false, //TODO: Change this in prod
                    'connect_timeout' => 30,
                ])
                ->post($this->baseUrl . '/api/Auth/RequestToken', [
                    'consumer_key' => $this->consumerKey,
                    'consumer_secret' => $this->consumerSecret
                ]);

            if ($response->successful()) {
                $this->token = $response->json('token');
                return $this->token;
            }

            throw new \Exception('PesaPal authentication failed: ' . $response->body());
        } catch (ConnectionException $e) {
            throw new \Exception('Connection to PesaPal failed: ' . $e->getMessage());
        } catch (\Exception $e) {
            throw new \Exception('PesaPal authentication error: ' . $e->getMessage());
        }
    }

    public function registerIPN()
    {
        try {
            if (!$this->token) {
                $this->getAuthJWT();
            }

            $payload = [
                'url' => $this->ipnUrl,
                'ipn_notification_type' => 'GET'
            ];


            $response = Http::timeout(30)
                ->retry(3, 100)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->token
                ])
                ->withOptions([
                    'verify' => false,
                    'connect_timeout' => 30,
                ])
                ->post($this->baseUrl . '/api/URLSetup/RegisterIPN', $payload);

            Log::info('PesaPal IPN Registration Response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                $ipn_details = $response->json();
                $this->ipn_id = $ipn_details['ipn_id'];
                return;
            }

            throw new \Exception('Failed to register IPN: ' . $response->body());
        } catch (\Exception $e) {
            throw new \Exception('Failed to register IPN URL: ' . $e->getMessage());
        }
    }

    public  function submitOrder($orderData)
    {
        if (!$this->token) {
            $this->getAuthJWT();
        }

        // if(!$this->ipn_id){
        //     $this->registerIPN();
        // }

        $payload = [
            'id' => Str::uuid()->toString(),
            'currency' => 'UGX',
            'amount' => $orderData['amount'],
            'description' => $orderData['description'],
            'callback_url' => $this->callbackUrl,
            'notification_id' => $this->notification_id,
            'billing_address' => [
                'email_address' => $orderData['email'],
                'phone_number' => $orderData['phone'],
                'first_name' => $orderData['first_name'],
                'last_name' => $orderData['last_name']
            ]
        ];

        $response = Http::withToken($this->token)
            ->post($this->baseUrl . '/api/Transactions/SubmitOrderRequest', $payload);

     if ($response->successful()) {
            return $response->json();
         }

         throw new \Exception('Failed to submit order: ' . $response->body());
    }

    public function getPaymentStatus($orderTrackingId)
    {
        if (!$this->token) {
            $this->getAuthJWT();
        }

        $response = Http::withToken($this->token)
            ->get($this->baseUrl . '/api/Transactions/GetTransactionStatus', [
                'orderTrackingId' => $orderTrackingId
            ]);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Failed to get payment status: ' . $response->body());
    }
}
