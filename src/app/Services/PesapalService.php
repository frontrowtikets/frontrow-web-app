<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PesapalService
{
    private $consumerKey;
    private $consumerSecret;
    private $baseUrl;
    private $callbackUrl;
    private $ipnUrl;
    private $token;

    public function __construct()
    {
        $this->consumerKey = config('services.pesapal.consumer_key');
        $this->consumerSecret = config('services.pesapal.consumer_secret');
        $this->baseUrl = config('services.pesapal.base_url');
        $this->callbackUrl = config('services.pesapal.callback_url');
        $this->ipnUrl = config('services.pesapal.ipn_url');
    }

    public function getAuthJWT()
    {
        $response = Http::post($this->baseUrl . '/api/Auth/RequestToken', [
            'consumer_key' => $this->consumerKey,
            'consumer_secret' => $this->consumerSecret
        ]);

        if ($response->successful()) {
            $this->token = $response->json('token');
            return $this->token;
        }

        throw new \Exception('PesaPal authentication failed: ' . $response->body());
    }

    public  function submitOrder($orderData)
    {
        if (!$this->token) {
            $this->getAuthJWT();
        }

        $payload = [
            'id' => Str::uuid()->toString(),
            'currency' => 'UGX',
            'amount' => $orderData['amount'],
            'description' => $orderData['description'],
            'callback_url' => $this->callbackUrl,
            'notification_id' => Str::random(20),
            'billing_address' => [
                'email_address' => $orderData['email'],
                'phone_number' => $orderData['phone'],
                'first_name' => $orderData['first_name'],
                'last_name' => $orderData['last_name']
            ]
        ];

        $response = Http::withToken($this->token)
            ->post($this->baseUrl . '/api/Transactions/SubmitOrder', $payload);

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
