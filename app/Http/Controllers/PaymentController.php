<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function index(Request $request)
    {
        return Inertia::render('Payments/Index', [
            'payments' => $this->paymentService->list(
                $request->user()->id,
                $request->get('search')
            ),

            'filters' => [
                'search' => $request->get('search'),
            ],
        ]);
    }

    public function show(Request $request, string $paymentId)
    {
        return Inertia::render('Payments/Show', [
            'payment' => $this->paymentService->find(
                $request->user()->id,
                $paymentId
            ),
        ]);
    }
}
