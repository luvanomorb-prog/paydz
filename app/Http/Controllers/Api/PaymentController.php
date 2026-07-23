<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Services\Payment\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $merchant = $request->user()->merchant;

        $payments = Payment::where('merchant_id', $merchant->id)
            ->with(['customer', 'paymentLink'])
            ->latest()
            ->paginate($request->integer('per_page', 15));

        return PaymentResource::collection($payments);
    }

    public function store(CreatePaymentRequest $request): JsonResponse
    {
        $merchant = $request->user()->merchant;

        $payment = Payment::create([
            'merchant_id' => $merchant->id,
            'customer_id' => $request->validated('customer_id'),
            'amount' => $request->validated('amount'),
            'currency' => $request->validated('currency', 'DZD'),
            'gateway' => $request->validated('gateway', 'satim'),
            'description' => $request->validated('description'),
            'metadata' => $request->validated('metadata', []),
        ]);

        return response()->json([
            'success' => true,
            'data' => new PaymentResource($payment),
        ], 201);
    }

    public function show(Request $request, Payment $payment): JsonResponse
    {
        $merchant = $request->user()->merchant;

        if ($payment->merchant_id !== $merchant->id) {
            return response()->json(['message' => 'Resource not found.'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new PaymentResource($payment->load(['customer', 'transactions'])),
        ]);
    }

    public function process(Request $request, Payment $payment): JsonResponse
    {
        $merchant = $request->user()->merchant;

        if ($payment->merchant_id !== $merchant->id) {
            return response()->json(['message' => 'Resource not found.'], 404);
        }

        $updatedPayment = $this->paymentService->processPayment($payment, $request->all());

        return response()->json([
            'success' => true,
            'data' => new PaymentResource($updatedPayment),
        ]);
    }
}
