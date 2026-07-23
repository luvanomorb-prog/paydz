<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\KycController as AdminKycController;
use App\Http\Controllers\Admin\MerchantController as AdminMerchantController;
use App\Http\Controllers\CheckoutPageController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Merchant\KycController as MerchantKycController;
use App\Http\Controllers\PaymentLinkDashboardController;
use App\Http\Controllers\PaymentManagementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Public Landing & Checkout Routes
Route::get('/', function () {
    return inertia('Welcome');
});

Route::get('/checkout/{session_id}', [CheckoutPageController::class, 'show'])->name('checkout.show');
Route::get('/pay/{public_id}', [CheckoutPageController::class, 'payLink'])->name('checkout.pay_link');

// Authenticated Merchant Dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('payments', PaymentManagementController::class)->only(['index', 'show']);
    Route::resource('payment-links', PaymentLinkDashboardController::class);
    Route::resource('transactions', TransactionController::class)->only(['index', 'show']);
    Route::resource('customers', CustomerController::class);

    // Merchant KYC Submissions
    Route::get('/kyc', [MerchantKycController::class, 'index'])->name('merchant.kyc.index');
    Route::post('/kyc', [MerchantKycController::class, 'store'])->name('merchant.kyc.store');

    // Profile Settings
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Control Panel
Route::middleware(['auth', 'admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/merchants', [AdminMerchantController::class, 'index'])->name('merchants.index');
    Route::get('/kyc', [AdminKycController::class, 'index'])->name('kyc.index');
    Route::post('/kyc/{document}/approve', [AdminKycController::class, 'approve'])->name('kyc.approve');
    Route::post('/kyc/{document}/reject', [AdminKycController::class, 'reject'])->name('kyc.reject');
});

require __DIR__.'/auth.php';
