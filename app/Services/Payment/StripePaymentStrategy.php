<?php

namespace App\Services\Payment;

use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripePaymentStrategy implements PaymentStrategy
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function pay($amount)
    {
        $paymentIntent = PaymentIntent::create([
            'amount' => $amount * 100, // Amount in cents
            'currency' => 'usd',
        ]);

        return $paymentIntent->client_secret;
    }
}
