<?php

namespace App\Services\Payment;

use App\Core\Enums\PaymentStatus;
use App\Core\Exceptions\PaymentException;
use App\Models\Payment;
use App\Models\Transaction;
use App\Services\GatewayManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    public function __construct(
        protected GatewayManager $gatewayManager
    ) {}

    /**
     * Process a payment in an atomic database transaction with pessimistic locking.
     */
    public function processPayment(Payment $payment, array $payload): Payment
    {
        return DB::transaction(function () use ($payment, $payload) {
            $lockedPayment = Payment::where('id', $payment->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedPayment->status === PaymentStatus::COMPLETED) {
                throw new PaymentException("Payment {$payment->id} is already completed.");
            }

            try {
                $gateway = $this->gatewayManager->driver($lockedPayment->gateway);
                $response = $gateway->charge([
                    'amount' => $lockedPayment->amount,
                    'currency' => $lockedPayment->currency,
                    'payload' => $payload,
                ]);

                if ($response->isSuccessful()) {
                    $lockedPayment->update([
                        'status' => PaymentStatus::COMPLETED,
                        'transaction_id' => $response->getTransactionId(),
                        'gateway_response' => $response->getRawResponse(),
                        'paid_at' => now(),
                    ]);

                    Transaction::create([
                        'merchant_id' => $lockedPayment->merchant_id,
                        'payment_id' => $lockedPayment->id,
                        'type' => 'charge',
                        'amount' => $lockedPayment->amount,
                        'status' => 'success',
                        'reference' => $response->getTransactionId(),
                    ]);
                } else {
                    $lockedPayment->update([
                        'status' => PaymentStatus::FAILED,
                        'gateway_response' => $response->getRawResponse(),
                        'failed_at' => now(),
                    ]);
                }

                return $lockedPayment;
            } catch (\Throwable $e) {
                Log::error('Payment Processing Failed', [
                    'payment_id' => $lockedPayment->id,
                    'error' => $e->getMessage(),
                ]);

                $lockedPayment->update([
                    'status' => PaymentStatus::FAILED,
                    'failed_at' => now(),
                ]);

                throw $e;
            }
        });
    }
}<?php

namespace App\Services\Payment;

use App\Core\Enums\PaymentStatus;
use App\Core\Exceptions\PaymentException;
use App\Models\Payment;
use App\Models\Transaction;
use App\Services\GatewayManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    public function __construct(
        protected GatewayManager $gatewayManager
    ) {}

    /**
     * Process a payment in an atomic database transaction with pessimistic locking.
     */
    public function processPayment(Payment $payment, array $payload): Payment
    {
        return DB::transaction(function () use ($payment, $payload) {
            $lockedPayment = Payment::where('id', $payment->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedPayment->status === PaymentStatus::COMPLETED) {
                throw new PaymentException("Payment {$payment->id} is already completed.");
            }

            try {
                $gateway = $this->gatewayManager->driver($lockedPayment->gateway);
                $response = $gateway->charge([
                    'amount' => $lockedPayment->amount,
                    'currency' => $lockedPayment->currency,
                    'payload' => $payload,
                ]);

                if ($response->isSuccessful()) {
                    $lockedPayment->update([
                        'status' => PaymentStatus::COMPLETED,
                        'transaction_id' => $response->getTransactionId(),
                        'gateway_response' => $response->getRawResponse(),
                        'paid_at' => now(),
                    ]);

                    Transaction::create([
                        'merchant_id' => $lockedPayment->merchant_id,
                        'payment_id' => $lockedPayment->id,
                        'type' => 'charge',
                        'amount' => $lockedPayment->amount,
                        'status' => 'success',
                        'reference' => $response->getTransactionId(),
                    ]);
                } else {
                    $lockedPayment->update([
                        'status' => PaymentStatus::FAILED,
                        'gateway_response' => $response->getRawResponse(),
                        'failed_at' => now(),
                    ]);
                }

                return $lockedPayment;
            } catch (\Throwable $e) {
                Log::error('Payment Processing Failed', [
                    'payment_id' => $lockedPayment->id,
                    'error' => $e->getMessage(),
                ]);

                $lockedPayment->update([
                    'status' => PaymentStatus::FAILED,
                    'failed_at' => now(),
                ]);

                throw $e;
            }
        });
    }
}
