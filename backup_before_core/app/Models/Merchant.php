<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\MerchantDocument;



class Merchant extends Model
{


    use HasFactory;





    protected $fillable = [


        'user_id',

        'business_name',

        'business_email',

        'business_phone',

        'country',

        'status',

        'kyc_verified',

        'api_key',

        'webhook_secret',

        'webhook_url'


    ];








    protected $casts = [


        'kyc_verified' => 'boolean'


    ];








    /*
    |--------------------------------------------------------------------------
    | User Relationship
    |--------------------------------------------------------------------------
    */


    public function user(): BelongsTo
    {

        return $this->belongsTo(User::class);

    }







    /*
    |--------------------------------------------------------------------------
    | Payments
    |--------------------------------------------------------------------------
    */


    public function payments(): HasMany
    {

        return $this->hasMany(Payment::class);

    }








    /*
    |--------------------------------------------------------------------------
    | Transactions
    |--------------------------------------------------------------------------
    */


    public function transactions(): HasMany
    {

        return $this->hasMany(Transaction::class);

    }








    /*
    |--------------------------------------------------------------------------
    | API Keys
    |--------------------------------------------------------------------------
    */


    public function apiKeys(): HasMany
    {

        return $this->hasMany(ApiKey::class);

    }








    /*
    |--------------------------------------------------------------------------
    | Webhooks
    |--------------------------------------------------------------------------
    */


    public function webhookEndpoints(): HasMany
    {

        return $this->hasMany(WebhookEndpoint::class);

    }



    public function documents(): HasMany
    {

        return $this->hasMany(
            MerchantDocument::class
        );

    }



}
