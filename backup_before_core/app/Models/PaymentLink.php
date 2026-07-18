<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;


class PaymentLink extends Model
{

public function payments()
{
    return $this->hasMany(Payment::class);
}

    use HasFactory;


    protected $fillable = [

        'merchant_id',

        'public_id',

        'uuid',

        'title',

        'description',

        'amount',

        'currency',

        'active',

        'max_payments',

        'payments_count',

        'views_count',

        'revenue',

        'expires_at',

        'collect_name',

        'collect_email',

        'collect_phone',

        'success_url',

        'cancel_url',

        'metadata',

    ];



    protected $casts = [

        'active' => 'boolean',

        'expires_at' => 'datetime',

        'metadata' => 'array',

        'amount' => 'decimal:2',

        'revenue' => 'decimal:2',

    ];





    protected static function boot()
    {

        parent::boot();


        static::creating(function ($link) {


            if(!$link->uuid)
            {
                $link->uuid = (string) Str::uuid();
            }



            if(!$link->public_id)
            {
                $link->public_id =
                    'pl_' . Str::random(18);
            }



        });


    }






    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */


    public function merchant()
    {

        return $this->belongsTo(
            Merchant::class
        );

    }





    /*
    |--------------------------------------------------------------------------
    | Route Binding
    |--------------------------------------------------------------------------
    */


    public function getRouteKeyName()
    {

        return 'public_id';

    }





    /*
    |--------------------------------------------------------------------------
    | Payment Link Status
    |--------------------------------------------------------------------------
    */


    public function isAvailable()
    {


        if(!$this->active)
        {
            return false;
        }



        if(
            $this->expires_at &&
            now()->greaterThan($this->expires_at)
        )
        {
            return false;
        }





        if(
            $this->max_payments &&
            $this->payments_count >= $this->max_payments
        )
        {
            return false;
        }



        return true;


    }





    /*
    |--------------------------------------------------------------------------
    | Public URL
    |--------------------------------------------------------------------------
    */


    public function url()
    {

        return url(
            '/pay/'.$this->public_id
        );

    }





    /*
    |--------------------------------------------------------------------------
    | Statistics
    |--------------------------------------------------------------------------
    */


    public function addView()
    {

        $this->increment(
            'views_count'
        );

    }





    public function addPayment($amount)
    {


        $this->increment(
            'payments_count'
        );


        $this->increment(
            'revenue',
            $amount
        );


    }



}
