<?php

namespace App\Services;

use App\Models\Merchant;
use App\Models\Webhook;
use Illuminate\Support\Facades\Http;

class WebhookService
{

    /**
     * Send webhook event to merchant
     */
    public function send(
        Merchant $merchant,
        string $event,
        array $data
    )
    {

        if(!$merchant->webhook_secret)
        {
            return false;
        }


        $payload = [
            'id' => 'evt_'.uniqid(),

            'event' => $event,

            'created' => time(),

            'data' => $data
        ];


        $body = json_encode($payload);


        $signature = $this->generateSignature(
            $body,
            $merchant->webhook_secret
        );


        Webhook::create([

            'merchant_id'=>$merchant->id,

            'event'=>$event,

            'payload'=>$payload,

            'signature'=>$signature,

            'status'=>'pending'

        ]);



        if(!$merchant->webhook_url)
        {
            return false;
        }



        try {


            $response = Http::withHeaders([

                'Content-Type'=>'application/json',

                'PayDZ-Signature'=>$signature

            ])
            ->post(
                $merchant->webhook_url,
                $payload
            );


            Webhook::latest()
            ->first()
            ->update([

                'status'=>$response->successful()
                    ? 'sent'
                    : 'failed'

            ]);


            return $response->successful();



        } catch(\Exception $e){


            return false;

        }

    }





    /**
     * Generate Stripe style HMAC signature
     */
    public function generateSignature(
        string $payload,
        string $secret
    )
    {


        $timestamp=time();


        $signedPayload =
            $timestamp.'.'.$payload;



        $signature = hash_hmac(
            'sha256',
            $signedPayload,
            $secret
        );


        return
        "t=".$timestamp.",v1=".$signature;

    }





    /**
     * Verify webhook signature
     */
    public function verify(
        string $payload,
        string $signature,
        string $secret
    )
    {


        $parts = explode(
            ',',
            $signature
        );


        $timestamp =
            str_replace(
                't=',
                '',
                $parts[0]
            );


        $hash =
            str_replace(
                'v1=',
                '',
                $parts[1]
            );



        $expected =
            hash_hmac(
                'sha256',
                $timestamp.'.'.$payload,
                $secret
            );



        return hash_equals(
            $expected,
            $hash
        );

    }


}
