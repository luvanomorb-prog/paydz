<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\ApiKeyController;
use App\Http\Controllers\Api\WebhookController;
use App\Http\Controllers\Api\MerchantController;
use App\Http\Controllers\Api\PaymentLinkController;
use App\Http\Controllers\Api\TransactionController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/


Route::prefix('v1')->group(function () {


    /*
    |--------------------------------------------------------------------------
    | Payment Links
    |--------------------------------------------------------------------------
    */


    Route::get(
        '/payment-links',
        [PaymentLinkController::class,'index']
    );


    Route::post(
        '/payment-links',
        [PaymentLinkController::class,'store']
    );


    Route::get(
        '/payment-links/{paymentLink}',
        [PaymentLinkController::class,'show']
    );


    Route::post(
        '/payment-links/{paymentLink}/disable',
        [PaymentLinkController::class,'disable']
    );


    Route::post(
        '/payment-links/{paymentLink}/enable',
        [PaymentLinkController::class,'enable']
    );


    Route::get(
        '/payment-links/{paymentLink}/stats',
        [PaymentLinkController::class,'stats']
    );





    /*
    |--------------------------------------------------------------------------
    | Payments
    |--------------------------------------------------------------------------
    */


    Route::post(
        '/payments',
        [PaymentController::class,'store']
    );


    Route::get(
        '/payments/{id}',
        [PaymentController::class,'show']
    );


    Route::post(
        '/payments/{id}/refund',
        [PaymentController::class,'refund']
    );





    /*
    |--------------------------------------------------------------------------
    | Checkout
    |--------------------------------------------------------------------------
    */


    Route::post(
        '/checkout/{id}/pay',
        [CheckoutController::class,'pay']
    );





    /*
    |--------------------------------------------------------------------------
    | Merchant
    |--------------------------------------------------------------------------
    */


    Route::get(
        '/merchant/payments',
        [MerchantController::class,'payments']
    );





    /*
    |--------------------------------------------------------------------------
    | Transactions
    |--------------------------------------------------------------------------
    */


    Route::get(
        '/transactions/{id}',
        [TransactionController::class,'show']
    );



});





/*
|--------------------------------------------------------------------------
| Payment Webhook
|--------------------------------------------------------------------------
*/


Route::post(
    '/webhook/payment',
    [
        WebhookController::class,
        'handle'
    ]
);

Route::post(
    '/webhook/test',
    [WebhookController::class,'receive']
);
Route::post(
    '/webhook/test',
    [
        WebhookController::class,
        'receive'
    ]
);
Route::post(
    '/webhook/receive',
    [
        WebhookController::class,
        'receive'
    ]
);
