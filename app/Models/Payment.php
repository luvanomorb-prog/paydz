<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Payment extends Model
{


protected $fillable=[

'merchant_id',
'payment_link_id',
'customer_name',
'customer_email',
'amount',
'currency',
'method',
'status',
'transaction_id',
'metadata'

];



public function merchant()
{
    return $this->belongsTo(Merchant::class);
}



public function transaction()
{
    return $this->hasOne(Transaction::class);
}


}
