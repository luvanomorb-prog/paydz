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

// Protected Merchant Routes (Sanctum / API Key)
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/user', [AuthController::class, 'me']);

    // Dashboard Statistics
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);

    // Payments API
Route::apiResource('payments', PaymentController::class)
    ->names('api.payments');
    Route::post('/payments/{payment}/process', [PaymentController::class, 'process']);

    // Payment Links API
    Route::apiResource('payment-links', PaymentLinkController::class);

    // Transactions API
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show']);

    // API Keys Management
    Route::get('/api-keys', [ApiKeyController::class, 'index']);
    Route::post('/api-keys', [ApiKeyController::class, 'store']);
    Route::delete('/api-keys/{apiKey}', [ApiKeyController::class, 'destroy']);

    // Merchant Profile
    Route::get('/merchant', [MerchantController::class, 'show']);
    Route::put('/merchant', [MerchantController::class, 'update']);
});
