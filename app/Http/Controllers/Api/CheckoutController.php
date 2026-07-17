<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentIntent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'merchant_id' => 'required|exists:merchants,id',
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'description' => 'nullable|string',
            'customer_email' => 'nullable|email',
            'customer_name' => 'nullable|string',
        ]);


        return DB::transaction(function () use ($request) {

            $intentId = 'pi_PDZ_' . strtoupper(Str::random(18));

            $clientSecret = 'cs_PDZ_' . Str::random(32);


            $paymentIntent = PaymentIntent::create([

                'merchant_id' => $request->merchant_id,

                'intent_id' => $intentId,

                'client_secret' => $clientSecret,

                'amount' => $request->amount,

                'currency' => $request->currency,

                'status' => 'requires_payment',

                'payment_method' => 'mock',

                'gateway' => 'mock',

                'description' => $request->description,

                'metadata' => [
                    'customer_email' => $request->customer_email,
                    'customer_name' => $request->customer_name,
                ],

            ]);


            return response()->json([

                'success' => true,

                'message' => 'Checkout session created',

                'payment_intent' => [

                    'id' => $paymentIntent->id,

                    'intent_id' => $paymentIntent->intent_id,

                    'client_secret' => $paymentIntent->client_secret,

                    'amount' => $paymentIntent->amount,

                    'currency' => $paymentIntent->currency,

                    'status' => $paymentIntent->status,

                ]

            ],201);

        });
    }
}
