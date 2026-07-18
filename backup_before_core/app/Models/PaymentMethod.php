<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{

    protected $fillable = [

        'code',
        'name',
        'provider',
        'active',
        'settings'

    ];


    protected $casts = [

        'active' => 'boolean',

        'settings' => 'array',

    ];

}
