<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Support\Str;

class PaymentService
{
    /**
     * إنشاء دفعة جديدة.
     */
    public function create(array $data): Payment
    {
        $payment = Payment::create([
            'merchant_id'        => $data['merchant_id'],
            'payment_id'         => 'PDZ_' . strtoupper(Str::random(20)),
            'amount'             => $data['amount'],
            'currency'           => $data['currency'] ?? 'DZD',
            'customer_email'     => $data['customer_email'] ?? null,
            'customer_name'      => $data['customer_name'] ?? null,
            'description'        => $data['description'] ?? null,
            'status'             => 'pending',
            'provider'           => null,
            'provider_reference' => null,
            'metadata'           => $data['metadata'] ?? null,
        ]);

        $transaction = Transaction::create([
            'payment_id'         => $payment->id,
            'transaction_id'     => 'TRX_' . strtoupper(Str::random(20)),
            'provider'           => null,
            'provider_reference' => null,
            'amount'             => $payment->amount,
            'currency'           => $payment->currency,
            'status'             => 'pending',
            'failure_reason'     => null,
            'metadata'           => null,
            'paid_at'            => null,
        ]);

        $payment->setRelation('transaction', $transaction);

        return $payment;
    }

    /**
     * قائمة المدفوعات.
     */
    public function list(int $merchantId, ?string $search = null)
    {
        return Payment::query()
            ->where('merchant_id', $merchantId)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('payment_id', 'like', "%{$search}%")
                      ->orWhere('customer_name', 'like', "%{$search}%")
                      ->orWhere('customer_email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
    }

    /**
     * جلب دفعة واحدة.
     */
    public function find(int $merchantId, string $paymentId): Payment
    {
        return Payment::with('transaction')
            ->where('merchant_id', $merchantId)
            ->where('payment_id', $paymentId)
            ->firstOrFail();
    }
}
