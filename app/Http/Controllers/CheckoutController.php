<?php

namespace App\Http\Controllers;

use App\Models\PaymentLink;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class CheckoutController extends Controller
{


public function show($public_id)
{


$link = PaymentLink::where(
'public_id',
$public_id
)
->firstOrFail();



return inertia(
'Checkout/Index',
[

'link'=>$link

]
);


}




public function pay(
Request $request,
$public_id
)
{


$link = PaymentLink::where(
'public_id',
$public_id
)
->firstOrFail();



$payment = Payment::create([


'merchant_id'=>$link->merchant_id,


'payment_link_id'=>$link->id,


'customer_name'=>$request->name,


'customer_email'=>$request->email,


'amount'=>$link->amount,


'currency'=>'DZD',


'method'=>$request->method,


'status'=>'pending',


'transaction_id'=>
'TX_'.Str::random(20),


]);




return response()->json([

'message'=>'Payment created',

'payment'=>$payment

]);


}





public function qr($id)
{


$payment =
Payment::findOrFail($id);



$data =
"PAYDZ|".
$payment->transaction_id.
"|".
$payment->amount;



return response(
QrCode::size(300)
->generate($data)
)
->header(
'Content-Type',
'image/svg+xml'
);


}


}
