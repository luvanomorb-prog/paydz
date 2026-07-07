<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Merchant extends Model
{
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
