<?php

use App\Http\Controllers\Api\ApiKeyController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\MerchantController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\PaymentLinkController;
use App\Http\Controllers\Api\SatimCallbackController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\WebhookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public Authentication
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Public Gateways & Callbacks
Route::post('/satim/callback', [SatimCallbackController::class, 'handle']);
Route::post('/webhooks/incoming/{gateway}', [WebhookController::class, 'handleIncoming']);

// Protected Merchant Routes
Route::middleware(['auth:sanctum', 'throttle:api'])
    ->name('api.')
    ->group(function () {

        Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::get('/auth/user', [AuthController::class, 'me'])->name('auth.user');

        // Dashboard
        Route::get('/dashboard/stats', [DashboardController::class, 'stats'])
            ->name('dashboard.stats');

        // Payments
        Route::apiResource('payments', PaymentController::class);

        Route::post('/payments/{payment}/process', [PaymentController::class, 'process'])
            ->name('payments.process');

        // Payment Links
        Route::apiResource('payment-links', PaymentLinkController::class);

        // Transactions
        Route::get('/transactions', [TransactionController::class, 'index'])
            ->name('transactions.index');

        Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])
            ->name('transactions.show');

        // API Keys
        Route::get('/api-keys', [ApiKeyController::class, 'index'])
            ->name('api-keys.index');

        Route::post('/api-keys', [ApiKeyController::class, 'store'])
            ->name('api-keys.store');

        Route::delete('/api-keys/{apiKey}', [ApiKeyController::class, 'destroy'])
            ->name('api-keys.destroy');

        // Merchant
        Route::get('/merchant', [MerchantController::class, 'show'])
            ->name('merchant.show');

        Route::put('/merchant', [MerchantController::class, 'update'])
            ->name('merchant.update');
    });
