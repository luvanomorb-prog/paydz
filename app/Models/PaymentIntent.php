<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentIntent extends Model
{

    protected $fillable = [

        'merchant_id',
        'intent_id',
        'amount',
        'currency',
        'status',
        'payment_method',
        'description',
        'metadata',
'client_secret',

    ];


    protected $casts = [

        'metadata'=>'array',

    ];



    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }


}
