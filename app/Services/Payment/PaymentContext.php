<?php

namespace App\Services\Payment;

class PaymentContext
{
    private $paymentStrategy;

    public function setPaymentStrategy(PaymentStrategy $paymentStrategy)
    {
        $this->paymentStrategy = $paymentStrategy;
    }

    public function pay($amount)
    {
        return $this->paymentStrategy->pay($amount);
    }
}
