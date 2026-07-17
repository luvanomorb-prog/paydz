<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Transaction;
use App\Models\Payment;
use App\Models\ApiKey;
use App\Models\WebhookEndpoint;

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

        'kyc_verified'=>'boolean'

    ];



    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }



    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }



    public function apiKeys(): HasMany
    {
        return $this->hasMany(ApiKey::class);
    }



    public function webhookEndpoints(): HasMany
    {
        return $this->hasMany(WebhookEndpoint::class);
    }

}
