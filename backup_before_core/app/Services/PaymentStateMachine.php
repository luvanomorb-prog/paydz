<?php

namespace App\Services;


use App\Models\Payment;

use Exception;




class PaymentStateMachine
{



    protected array $transitions = [


        'created' => [

            'pending'

        ],



        'pending' => [

            'processing',

            'requires_action',

            'failed',

            'cancelled'

        ],




        'processing' => [

           'requires_action',
 
            'paid',

            'failed'

        ],




        'paid' => [

            'refunded'

        ],


'requires_action' => [

    'processing',

    'paid',

    'failed'

],

        'failed' => [],



        'cancelled' => [],



        'refunded' => []



    ];









    /*
    |--------------------------------------------------------------------------
    | Check Transition
    |--------------------------------------------------------------------------
    */


    public function canTransition(
        string $from,
        string $to
    ): bool
    {


        return in_array(

            $to,

            $this->transitions[$from] ?? []

        );


    }









    /*
    |--------------------------------------------------------------------------
    | Change Payment Status
    |--------------------------------------------------------------------------
    */


    public function transition(
        Payment $payment,
        string $newStatus
    ): Payment
    {



        $oldStatus = $payment->status;





        if(
            !$this->canTransition(
                $oldStatus,
                $newStatus
            )
        ){


            throw new Exception(

                "Invalid payment transition: {$oldStatus} -> {$newStatus}"

            );


        }






        $payment->update([


            'status'=>$newStatus


        ]);






        return $payment;


    }







    /*
    |--------------------------------------------------------------------------
    | Available Next Statuses
    |--------------------------------------------------------------------------
    */


    public function nextStatuses(
        Payment $payment
    ): array
    {


        return $this->transitions[
            $payment->status
        ] ?? [];


    }





}
