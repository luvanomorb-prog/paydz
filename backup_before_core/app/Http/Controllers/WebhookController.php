<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Payment;



class WebhookController extends Controller
{


public function handle(Request $request)
{


$payment =
Payment::where(
'transaction_id',
$request->transaction_id
)
->firstOrFail();



if($request->status=="paid"){


$payment->update([

'status'=>'paid'

]);



$link=$payment->paymentLink;


$link->increment(
'payments_count'
);



$link->increment(
'revenue',
$payment->amount
);



}



if($request->status=="failed"){


$payment->update([

'status'=>'failed'

]);


}



return response()->json([

'success'=>true

]);


}


}

