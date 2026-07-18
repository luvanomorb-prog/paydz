<?php

namespace App\Http\Controllers;

use App\Models\CheckoutSession;

class CheckoutPageController extends Controller
{

    public function show($sessionId)
    {

        $session = CheckoutSession::with([
            'merchant',
            'payment'
        ])
        ->where('session_id',$sessionId)
        ->firstOrFail();


        return view('checkout.show',[
            'session'=>$session
        ]);

    }


}
