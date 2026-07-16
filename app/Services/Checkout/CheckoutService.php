<?php

namespace App\Services\Checkout;

use App\Models\Payment;

class CheckoutService
{
    public function generateUrl(Payment $payment): string
    {
        return url('/pay/' . $payment->payment_id);
    }
}
