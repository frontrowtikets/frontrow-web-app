<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PaymentController extends Controller
{
    public function verifyPayment(Request $request)
    {
        if (Auth::check()) {
            return \Inertia\Inertia::render('Payment/VerifyPaymentPage', [
                'OrderTrackingId' => $request->OrderTrackingId,
                'OrderNotificationType' => $request->OrderNotificationType,
                'OrderMerchantReference' => $request->OrderMerchantReference
            ]);
        } else {
            return \Inertia\Inertia::render(
                'Payment/VerifyPaymentPageHome',
                [
                    'OrderTrackingId' => $request->OrderTrackingId,
                    'OrderNotificationType' => $request->OrderNotificationType,
                    'OrderMerchantReference' => $request->OrderMerchantReference
                ]
            );
        }
    }
}
