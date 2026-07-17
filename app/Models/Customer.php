<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'merchant_id',

        'customer_id',

        'name',

        'email',

        'phone',

        'company',

        'country',

        'metadata',

    ];

    protected $casts = [

        'metadata' => 'array',

    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
