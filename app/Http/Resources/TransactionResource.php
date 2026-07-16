<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'reference' => $this->reference,

            'amount' => $this->amount,

            'currency' => $this->currency,

            'status' => $this->status,

            'payment_method' => $this->payment_method,

            'gateway' => $this->gateway,

            'merchant' => [
                'id' => $this->merchant?->id,
                'business_name' => $this->merchant?->business_name,
            ],

            'customer' => [
                'id' => $this->customer?->id,
                'name' => $this->customer?->name,
                'email' => $this->customer?->email,
            ],

            'created_at' => $this->created_at,

            'paid_at' => $this->paid_at,

        ];
    }
}
