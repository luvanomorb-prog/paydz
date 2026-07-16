<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Payment extends Model
{
    use HasFactory;


    protected $fillable = [

        'merchant_id',
        'payment_id',
        'amount',
        'currency',
        'customer_email',
        'customer_name',
        'description',
        'status',
        'provider',
        'provider_reference',
        'metadata',
        'paid_at',

    ];


    protected $casts = [

        'metadata' => 'array',
        'paid_at' => 'datetime',

    ];



    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }



    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

}
