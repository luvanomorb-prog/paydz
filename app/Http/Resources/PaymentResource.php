<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class PaymentResource extends JsonResource
{

    public function toArray(Request $request): array
    {

        return [

            'id'=>$this->id,

            'payment_intent_id'=>
                $this->payment_intent_id,


            'amount'=>$this->amount,


            'currency'=>$this->currency,


            'status'=>$this->status,


            'description'=>$this->description,


            'transaction'=>

                [
                    'id'=>$this->transaction?->id,

                    'reference'=>
                    $this->transaction?->reference
                ],


            'created_at'=>$this->created_at

        ];

    }

}
