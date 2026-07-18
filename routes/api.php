<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\CheckoutSessionController;
use App\Http\Controllers\Api\SatimCallbackController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/



/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/


Route::post(
    '/register',
    [AuthController::class,'register']
);


Route::post(
    '/login',
    [AuthController::class,'login']
);





/*
|--------------------------------------------------------------------------
| Checkout Sessions
|--------------------------------------------------------------------------
*/


Route::post(
    '/checkout/sessions',
    [
        CheckoutSessionController::class,
        'store'
    ]
);



Route::get(
    '/checkout/sessions/{sessionId}',
    [
        CheckoutSessionController::class,
        'show'
    ]
);



Route::post(
    '/checkout/sessions/{sessionId}/complete',
    [
        CheckoutSessionController::class,
        'complete'
    ]
);






/*
|--------------------------------------------------------------------------
| Payments
|--------------------------------------------------------------------------
*/


Route::post(
    '/payments/{payment}/pay',
    [
        PaymentController::class,
        'pay'
    ]
);



Route::get(
    '/payments/{payment}/verify',
    [
        PaymentController::class,
        'verify'
    ]
);


Route::post(
    '/satim/callback',
    [
        SatimCallbackController::class,
        'handle'
    ]
);

