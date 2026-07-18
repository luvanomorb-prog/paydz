<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Webhook extends Model
{

    protected $fillable = [

        'merchant_id',

        'event',

        'payload',

        'signature',

        'status'

    ];


    protected $casts = [

        'payload'=>'array'

    ];


}
