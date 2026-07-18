<?php

namespace App\Services;

use App\Models\Merchant;
use App\Models\Webhook;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;


class WebhookService
{


    /**
     * Send webhook event
     */
    public function send(
        Merchant $merchant,
        string $event,
        array $data
    ): bool
    {


        if(!$merchant->webhook_secret)
        {
            return false;
        }



        $payload = [

            'id'=>'evt_'.Str::uuid(),

            'event'=>$event,

            'created'=>time(),

            'data'=>$data

        ];




        $body = json_encode(
            $payload,
            JSON_UNESCAPED_SLASHES
        );




        $signature = $this->generateSignature(
            $body,
            $merchant->webhook_secret
        );




        $webhook = Webhook::create([

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


            $response = Http::timeout(10)

            ->withHeaders([

                'Content-Type'=>'application/json',

                'PayDZ-Signature'=>$signature

            ])

            ->post(

                $merchant->webhook_url,

                $payload

            );





            $webhook->update([

                'status'=>
                    $response->successful()
                    ?
                    'sent'
                    :
                    'failed'

            ]);





            return $response->successful();



        }
        catch(\Throwable $e)
        {


            $webhook->update([

                'status'=>'failed'

            ]);



            return false;

        }



    }







    /**
     * Generate signature
     */
    public function generateSignature(
        string $payload,
        string $secret
    ): string
    {


        $timestamp=time();



        $signature = hash_hmac(

            'sha256',

            $timestamp.'.'.$payload,

            $secret

        );



        return

        't='.
        $timestamp.
        ',v1='.
        $signature;


    }








    /**
     * Verify incoming webhook
     */
    public function verify(
        string $payload,
        string $signature,
        string $secret
    ): bool
    {


        $parts = explode(
            ',',
            $signature
        );



        if(count($parts)!==2)
        {
            return false;
        }




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




        $expected = hash_hmac(

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
