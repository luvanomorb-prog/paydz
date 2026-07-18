<?php

namespace App\Http\Controllers;

use App\Services\Checkout\CheckoutSessionService;
use Inertia\Inertia;

class CheckoutController extends Controller
{

    public function __construct(
        protected CheckoutSessionService $checkoutService
    ){}



    /*
    |--------------------------------------------------------------------------
    | Show Checkout Page
    |--------------------------------------------------------------------------
    */

    public function show($sessionId)
    {

        $session = $this->checkoutService
            ->find($sessionId);



        return Inertia::render(
            'Checkout/Show',
            [

                'session'=>$session

            ]
        );

    }

}
