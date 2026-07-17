<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentLinkController;
use App\Http\Controllers\PaymentLinkDashboardController;
use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\CheckoutController;


Route::get(
'/checkout/{public_id}',
[
CheckoutController::class,
'show'
]
)
->name('checkout');



Route::post(
'/checkout/{public_id}/pay',
[
CheckoutController::class,
'pay'
]
);



Route::get(
'/payment/{id}/qr',
[
CheckoutController::class,
'qr'
]
);

Route::middleware('auth')->group(function(){


Route::get(
'/settings/api-keys',
[
ApiKeyController::class,
'index'
]
)
->name('api.keys');


Route::post(
'/settings/api-keys/regenerate',
[
ApiKeyController::class,
'regenerate'
]
)
->name('api.keys.regenerate');


});

/*
|--------------------------------------------------------------------------
| Public Payment Checkout
|--------------------------------------------------------------------------
*/

// صفحة الدفع العامة مثل Stripe
Route::get('/pay/{paymentLink}', 
    [PaymentLinkController::class, 'show']
)->name('payment-links.show');


// تنفيذ الدفع
Route::post('/pay/{paymentLink}/process',
    [PaymentController::class, 'process']
)->name('payment.process');


// نجاح الدفع
Route::get('/payment/success/{payment}',
    [PaymentController::class, 'success']
)->name('payment.success');


// إلغاء الدفع
Route::get('/payment/cancel/{payment}',
    [PaymentController::class, 'cancel']
)->name('payment.cancel');



/*
|--------------------------------------------------------------------------
| Authenticated Merchant Dashboard
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {


    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard',
        [DashboardController::class,'index']
    )->name('dashboard');



    /*
    |--------------------------------------------------------------------------
    | Payment Links Management
    |--------------------------------------------------------------------------
    */


    Route::prefix('dashboard/payment-links')
        ->name('dashboard.payment-links.')
        ->group(function(){


            // قائمة الروابط
            Route::get('/',
                [PaymentLinkDashboardController::class,'index']
            )->name('index');


            // إنشاء رابط
            Route::get('/create',
                [PaymentLinkDashboardController::class,'create']
            )->name('create');


            Route::post('/',
                [PaymentLinkDashboardController::class,'store']
            )->name('store');


            // عرض رابط
            Route::get('/{paymentLink}',
                [PaymentLinkDashboardController::class,'show']
            )->name('show');


            // تعديل
            Route::get('/{paymentLink}/edit',
                [PaymentLinkDashboardController::class,'edit']
            )->name('edit');


            Route::put('/{paymentLink}',
                [PaymentLinkDashboardController::class,'update']
            )->name('update');


            // تعطيل الرابط
            Route::post('/{paymentLink}/disable',
                [PaymentLinkDashboardController::class,'disable']
            )->name('disable');


            // تفعيل الرابط
            Route::post('/{paymentLink}/enable',
                [PaymentLinkDashboardController::class,'enable']
            )->name('enable');


            // إحصائيات الرابط
            Route::get('/{paymentLink}/stats',
                [PaymentLinkDashboardController::class,'stats']
            )->name('stats');

        });



    /*
    |--------------------------------------------------------------------------
    | Transactions
    |--------------------------------------------------------------------------
    */

    Route::get('/payments',
        [PaymentController::class,'index']
    )->name('payments.index');


    Route::get('/payments/{payment}',
        [PaymentController::class,'show']
    )->name('payments.show');



});



require __DIR__.'/auth.php';
use App\Http\Controllers\TransactionController;


Route::middleware('auth')->group(function(){

    Route::get('/transactions',
        [TransactionController::class,'index']
    )->name('transactions.index');


    Route::get('/transactions/{transaction}',
        [TransactionController::class,'show']
    )->name('transactions.show');

});
