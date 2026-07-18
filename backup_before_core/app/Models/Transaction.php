<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Transaction extends Model
{

    use HasFactory;


    protected $fillable = [

        'merchant_id',

        'payment_id',

        'transaction_id',

        'type',

        'amount',

        'currency',

        'status',

        'reference',

        'provider',

        'provider_reference',

        'gateway',

        'gateway_reference',

        'failure_reason',

        'raw_response',

        'paid_at',

        'metadata'

    ];



    protected $casts = [

        'amount'=>'decimal:2',

        'metadata'=>'array',

        'raw_response'=>'array',

        'paid_at'=>'datetime'

    ];



    public function merchant(): BelongsTo
    {
        return $this->belongsTo(
            Merchant::class
        );
    }



    public function payment(): BelongsTo
    {
        return $this->belongsTo(
            Payment::class
        );
    }



    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }


    public function isPending(): bool
    {
        return $this->status === 'pending';
    }


    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

}
