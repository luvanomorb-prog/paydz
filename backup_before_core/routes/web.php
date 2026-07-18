<?php


use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/


use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardExportController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CheckoutPageController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\MerchantController;
use App\Http\Controllers\Admin\KycController as AdminKycController;


use App\Http\Controllers\Merchant\KycController as MerchantKycController;





/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/


Route::get('/', function () {

    return redirect()->route('dashboard');

});







/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/


Route::middleware([
    'auth',
    'verified'
])
->group(function () {





    /*
    |--------------------------------------------------------------------------
    | Merchant Dashboard
    |--------------------------------------------------------------------------
    */


    Route::get(
        '/dashboard',
        [DashboardController::class,'index']
    )
    ->name('dashboard');







    /*
    |--------------------------------------------------------------------------
    | Dashboard Export
    |--------------------------------------------------------------------------
    */


    Route::prefix('dashboard/export')
    ->name('dashboard.export.')
    ->group(function(){



        Route::get(
            '/payments',
            [DashboardExportController::class,'paymentsCsv']
        )
        ->name('payments');



        Route::get(
            '/transactions',
            [DashboardExportController::class,'transactionsCsv']
        )
        ->name('transactions');



        Route::get(
            '/pdf',
            [DashboardExportController::class,'pdf']
        )
        ->name('pdf');


    });









    /*
    |--------------------------------------------------------------------------
    | Merchant KYC
    |--------------------------------------------------------------------------
    */


    Route::prefix('merchant')
    ->name('merchant.')
    ->group(function(){



        Route::get(
            '/kyc',
            [MerchantKycController::class,'index']
        )
        ->name('kyc');



        Route::post(
            '/kyc',
            [MerchantKycController::class,'store']
        )
        ->name('kyc.store');



    });













    /*
    |--------------------------------------------------------------------------
    | Admin Panel
    |--------------------------------------------------------------------------
    */


    Route::middleware('admin')
    ->prefix('admin')
    ->name('admin.')
    ->group(function(){





        /*
        |--------------------------------------------------------------------------
        | Admin Dashboard
        |--------------------------------------------------------------------------
        */


        Route::get(
            '/',
            [AdminDashboardController::class,'index']
        )
        ->name('dashboard');









        /*
        |--------------------------------------------------------------------------
        | Merchants Management
        |--------------------------------------------------------------------------
        */


        Route::prefix('merchants')
        ->name('merchants.')
        ->group(function(){



            Route::get(
                '/',
                [MerchantController::class,'index']
            )
            ->name('index');



            Route::post(
                '/{merchant}/verify',
                [MerchantController::class,'verify']
            )
            ->name('verify');



            Route::post(
                '/{merchant}/reject',
                [MerchantController::class,'reject']
            )
            ->name('reject');



            Route::post(
                '/{merchant}/suspend',
                [MerchantController::class,'suspend']
            )
            ->name('suspend');


        });









        /*
        |--------------------------------------------------------------------------
        | KYC Management
        |--------------------------------------------------------------------------
        */


        Route::prefix('kyc')
        ->name('kyc.')
        ->group(function(){



            Route::get(
                '/',
                [AdminKycController::class,'index']
            )
            ->name('index');





            Route::get(
                '/{document}/view',
                [AdminKycController::class,'view']
            )
            ->name('view');





            Route::post(
                '/{document}/approve',
                [AdminKycController::class,'approve']
            )
            ->name('approve');





            Route::post(
                '/{document}/reject',
                [AdminKycController::class,'reject']
            )
            ->name('reject');



        });






    });





});



/*
|--------------------------------------------------------------------------
| Public Checkout
|--------------------------------------------------------------------------
*/

Route::get(
    '/checkout/{session}',
    [CheckoutController::class,'show']
)
->name('checkout.show');





require __DIR__.'/auth.php';
