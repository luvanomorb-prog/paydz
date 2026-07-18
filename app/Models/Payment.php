<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;



class Payment extends Model
{


    use HasFactory;




protected $fillable = [

    'merchant_id',

    'payment_link_id',

    'payment_id',

    'customer_name',

    'customer_email',

    'amount',

    'currency',

    'method',

    'status',

    'transaction_id',

    'description',

    'provider',

    'provider_reference',

    'metadata'

];




    protected $casts = [


        'amount' => 'decimal:2',


        'metadata' => 'array'


    ];







    /*
    |--------------------------------------------------------------------------
    | Merchant
    |--------------------------------------------------------------------------
    */


    public function merchant(): BelongsTo
    {

        return $this->belongsTo(
            Merchant::class
        );

    }








    /*
    |--------------------------------------------------------------------------
    | Payment Link
    |--------------------------------------------------------------------------
    */


    public function paymentLink(): BelongsTo
    {

        return $this->belongsTo(
            PaymentLink::class
        );

    }








    /*
    |--------------------------------------------------------------------------
    | Transaction
    |--------------------------------------------------------------------------
    */


    public function transaction(): HasOne
    {

        return $this->hasOne(
            Transaction::class
        );

    }








    /*
    |--------------------------------------------------------------------------
    | Status Helpers
    |--------------------------------------------------------------------------
    */


    public function isPending(): bool
    {

        return $this->status === 'pending';

    }



    public function isProcessing(): bool
    {

        return $this->status === 'processing';

    }



    public function isPaid(): bool
    {

        return $this->status === 'paid';

    }



    public function isFailed(): bool
    {

        return $this->status === 'failed';

    }



    public function isRefunded(): bool
    {

        return $this->status === 'refunded';

    }









    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */


    public function scopePaid($query)
    {

        return $query->where(
            'status',
            'paid'
        );

    }





    public function scopePending($query)
    {

        return $query->where(
            'status',
            'pending'
        );

    }





    public function scopeFailed($query)
    {

        return $query->where(
            'status',
            'failed'
        );

    }








    /*
    |--------------------------------------------------------------------------
    | Payment Status List
    |--------------------------------------------------------------------------
    */


    public static function statuses(): array
    {

        return [

            'created',

            'pending',

            'processing',

            'paid',

            'failed',

            'cancelled',

            'refunded'


        ];

    }





}
