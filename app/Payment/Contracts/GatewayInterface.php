<?php

namespace App\Payment\Contracts;

use App\Models\Payment;

interface GatewayInterface
{
    /**
     * Create payment.
     */
    public function create(Payment $payment): array;

    /**
     * Verify payment.
     */
    public function verify(Payment $payment): array;

    /**
     * Refund payment.
     */
    public function refund(Payment $payment, float $amount): array;

    /**
     * Cancel payment.
     */
    public function cancel(Payment $payment): array;

    /**
     * Gateway name.
     */
    public function name(): string;
}
