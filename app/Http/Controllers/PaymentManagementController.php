<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\Payment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentManagementController extends Controller
{
    public function index(Request $request)
    {
\Log::info('PAYMENTS INDEX ENTERED');
        $merchant = Merchant::where('user_id', $request->user()->id)
            ->firstOrFail();

        $payments = Payment::where('merchant_id', $merchant->id)
            ->latest()
            ->paginate(15);

        return Inertia::render('Payments/Index', [
            'payments' => $payments,
        ]);
    }
}
