<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ApiKey extends Model
{


protected $fillable = [

    'merchant_id',
    'public_key',
    'secret_key',

];


protected $hidden = [

    'secret_key',

];



public function merchant()
{

    return $this->belongsTo(
        Merchant::class
    );

}


}
