<?php

namespace App\Payment\Processor;

use App\Models\Payment;
use App\Payment\Contracts\GatewayInterface;
use App\Services\PaymentStateMachine;
use App\Enums\PaymentStatus;

class PaymentProcessor
{
    public function __construct(
        protected GatewayInterface $gateway,
        protected PaymentStateMachine $stateMachine
    ) {
    }

    /**
     * Create payment on the selected gateway.
     */
    public function create(Payment $payment): array
    {
        return $this->gateway->create($payment);
    }

    /**
     * Verify payment status.
     */
    public function verify(Payment $payment): Payment
    {
        $response = $this->gateway->verify($payment);

        if (!($response['success'] ?? false)) {
            $this->stateMachine->markAsFailed($payment);
            return $payment->refresh();
        }

        return match ($response['status']) {
            'paid' => $this->stateMachine->markAsPaid($payment),
            'failed' => $this->stateMachine->markAsFailed($payment),
            'cancelled' => $this->stateMachine->cancel($payment),
            'expired' => $this->stateMachine->expire($payment),
            default => $payment,
        };
    }

    /**
     * Cancel payment.
     */
    public function cancel(Payment $payment): Payment
    {
        $this->gateway->cancel($payment);

        return $this->stateMachine->cancel($payment);
    }

    /**
     * Refund payment.
     */
    public function refund(Payment $payment, float $amount): array
    {
        return $this->gateway->refund($payment, $amount);
    }
}
