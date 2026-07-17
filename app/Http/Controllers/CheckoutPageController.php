<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class CheckoutPageController extends Controller
{
    public function show($intent_id)
    {
        return Inertia::render('Checkout/Checkout',[
            'intent'=>$intent_id
        ]);
    }
}
