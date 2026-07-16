<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class CheckoutSession extends Model
{

    use HasFactory;


    protected $fillable = [

        'merchant_id',
        'payment_id',
        'session_id',
        'product_name',
        'description',
        'success_url',
        'cancel_url',
        'status',
        'expires_at'

    ];



    protected $casts = [

        'expires_at'=>'datetime'

    ];



    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }



    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

}
