<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Payment\PaymentContext;
use App\Services\Payment\StripePaymentStrategy;
use App\Services\Payment\PayPalPaymentStrategy;

class PaymentController extends Controller
{
    protected $paymentContext;

    public function __construct(PaymentContext $paymentContext)
    {
        $this->paymentContext = $paymentContext;
    }

    public function checkout()
    {
        $cartItems = \Cart::getContent(); // assuming you have a Cart facade or equivalent
        $total = \Cart::getTotal(); // assuming you have a Cart facade or equivalent
        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function payWithStripe(Request $request)
    {
        $this->paymentContext->setPaymentStrategy(new StripePaymentStrategy());
        $clientSecret = $this->paymentContext->pay($request->amount);

        return view('checkout.stripe', compact('clientSecret'));
    }

    public function payWithPayPal(Request $request)
    {
        $this->paymentContext->setPaymentStrategy(new PayPalPaymentStrategy());
        $approvalLink = $this->paymentContext->pay($request->amount);

        return redirect($approvalLink);
    }

    public function paypalSuccess(Request $request)
    {
        // Handle success logic here

        return redirect()->route('products.index')->with('success', 'Payment successful!');
    }

    public function paypalCancel()
    {
        // Handle cancellation logic here

        return redirect()->route('checkout.index')->with('error', 'Payment cancelled!');
    }
}
