<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentLink;
use App\Models\Merchant;
use Illuminate\Support\Str;

class PaymentLinkDashboardController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        $merchant = Merchant::where('user_id',$user->id)->firstOrFail();


        $links = PaymentLink::where(
            'merchant_id',
            $merchant->id
        )
        ->latest()
        ->get();


        return inertia(
            'PaymentLinks/Index',
            [
                'links'=>$links
            ]
        );
    }



    public function create()
    {
        return inertia(
            'PaymentLinks/Create'
        );
    }



    public function store(Request $request)
    {

        $user = Auth::user();

        $merchant = Merchant::where('user_id',$user->id)
        ->firstOrFail();


        $data = $request->validate([

            'title'=>'required|string|max:255',

            'description'=>'nullable|string',

            'amount'=>'required|numeric|min:1',

            'currency'=>'required|string',

            'max_payments'=>'nullable|integer',

            'expires_at'=>'nullable|date',

        ]);



        $link = PaymentLink::create([

            'merchant_id'=>$merchant->id,

            'public_id'=>'pl_'.Str::random(24),

            'uuid'=>Str::uuid(),

            'title'=>$data['title'],

            'description'=>$data['description'] ?? null,

            'amount'=>$data['amount'],

            'currency'=>$data['currency'],

            'max_payments'=>$data['max_payments'] ?? null,

            'expires_at'=>$data['expires_at'] ?? null,

            'active'=>true,

        ]);



        return redirect()
        ->route('payment-links.dashboard')
        ->with('success','Payment link created');

    }



    public function disable(PaymentLink $paymentLink)
    {

        $paymentLink->update([
            'active'=>false
        ]);


        return back();

    }



    public function enable(PaymentLink $paymentLink)
    {

        $paymentLink->update([
            'active'=>true
        ]);


        return back();

    }


}
