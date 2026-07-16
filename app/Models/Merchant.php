<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\ApiKey;
use App\Models\Payment;

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
    ];

    protected $casts = [
        'kyc_verified' => 'boolean',
    ];

    /**
     * Owner of the merchant account.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Merchant API Keys.
     */
    public function apiKeys()
    {
        return $this->hasMany(ApiKey::class);
    }

    /**
     * Merchant Payments.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
