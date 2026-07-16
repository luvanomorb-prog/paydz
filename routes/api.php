<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\TransactionController;

Route::middleware('auth:sanctum')->group(function(){

    Route::post(
        '/payments',
        [PaymentController::class,'store']
    );

    Route::get(
        '/payments/{id}',
        [PaymentController::class,'show']
    );


    Route::get(
        '/transactions',
        [TransactionController::class,'index']
    );


    Route::get(
        '/transactions/{transaction}',
        [TransactionController::class,'show']
    );

});
