<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Transaction extends Model
{


protected $fillable=[

'merchant_id',
'payment_id',
'type',
'amount',
'currency',
'status',
'reference'

];



public function merchant()
{
    return $this->belongsTo(Merchant::class);
}



public function payment()
{
    return $this->belongsTo(Payment::class);
}


}
