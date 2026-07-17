<?php

namespace App\Services;

use App\Enums\PaymentStatus;
use App\Models\Payment;
use InvalidArgumentException;

class PaymentStateMachine
{
    /**
     * Change payment status.
     */
    public function transition(
        Payment $payment,
        PaymentStatus $newStatus
    ): Payment {

        $currentStatus = PaymentStatus::from($payment->status);

        if (! $currentStatus->canTransitionTo($newStatus)) {

            throw new InvalidArgumentException(
                sprintf(
                    'Cannot change payment status from [%s] to [%s].',
                    $currentStatus->value,
                    $newStatus->value
                )
            );

        }

        $payment->status = $newStatus->value;

        if ($newStatus === PaymentStatus::Paid) {
            $payment->paid_at = now();
        }

        $payment->save();

        return $payment->refresh();
    }

    /**
     * Mark payment as paid.
     */
    public function markAsPaid(Payment $payment): Payment
    {
        return $this->transition(
            $payment,
            PaymentStatus::Paid
        );
    }

    /**
     * Mark payment as failed.
     */
    public function markAsFailed(Payment $payment): Payment
    {
        return $this->transition(
            $payment,
            PaymentStatus::Failed
        );
    }

    /**
     * Cancel payment.
     */
    public function cancel(Payment $payment): Payment
    {
        return $this->transition(
            $payment,
            PaymentStatus::Cancelled
        );
    }

    /**
     * Expire payment.
     */
    public function expire(Payment $payment): Payment
    {
        return $this->transition(
            $payment,
            PaymentStatus::Expired
        );
    }
}
