<?php

namespace App\Services;


use Illuminate\Support\Str;
use App\Models\ApiKey;



class ApiKeyService
{


public function create($merchant)
{


return ApiKey::create([


'merchant_id'=>$merchant->id,


'public_key'=>
'pk_paydz_'.Str::random(24),


'secret_key'=>
'sk_paydz_'.Str::random(48),


]);


}




public function regenerate($merchant)
{


$key=$merchant->apiKey;


$key->update([


'secret_key'=>
'sk_paydz_'.Str::random(48)


]);


return $key;


}



}
