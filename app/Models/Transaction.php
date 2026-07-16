<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Transaction extends Model
{
    use HasFactory;


    protected $fillable = [

        'payment_id',
        'transaction_id',
        'provider',
        'provider_reference',
        'amount',
        'currency',
        'status',
        'failure_reason',
        'metadata',
        'paid_at',

    ];



    protected $casts = [

        'metadata' => 'array',
        'paid_at' => 'datetime',

    ];



    public function payment()
    {
        return $this->belongsTo(
            Payment::class
        );
    }

}
