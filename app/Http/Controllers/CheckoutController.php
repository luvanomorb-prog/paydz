<?php

namespace App\Http\Controllers;

use App\Services\CheckoutService;
use Illuminate\Http\Request;
use Inertia\Inertia;


class CheckoutController extends Controller
{

    protected CheckoutService $service;


    public function __construct(
        CheckoutService $service
    )
    {
        $this->service = $service;
    }



    public function show($session)
    {

        $checkout =
            $this->service
            ->findBySession($session);



        return Inertia::render(
            'Checkout/Show',
            [
                'checkout'=>$checkout
            ]
        );

    }

}
