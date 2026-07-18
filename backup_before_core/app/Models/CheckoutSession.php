<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class CheckoutSession extends Model
{

    use HasFactory;



    protected $fillable = [

        'merchant_id',

        'payment_id',

        'session_id',

        'customer_name',

        'customer_email',

        'amount',

        'currency',

        'status',

        'success_url',

        'cancel_url',

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
    | Payment
    |--------------------------------------------------------------------------
    */


    public function payment(): BelongsTo
    {

        return $this->belongsTo(
            Payment::class
        );

    }





    /*
    |--------------------------------------------------------------------------
    | Status Helpers
    |--------------------------------------------------------------------------
    */


    public function isOpen(): bool
    {

        return $this->status === 'open';

    }



    public function isCompleted(): bool
    {

        return $this->status === 'completed';

    }



    public function isExpired(): bool
    {

        return $this->status === 'expired';

    }



    public function isCancelled(): bool
    {

        return $this->status === 'cancelled';

    }





    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */


    public function scopeOpen($query)
    {

        return $query->where(
            'status',
            'open'
        );

    }





    public function scopeCompleted($query)
    {

        return $query->where(
            'status',
            'completed'
        );

    }





}
