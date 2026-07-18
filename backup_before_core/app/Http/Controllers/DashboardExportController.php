<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Merchant;
use App\Models\Payment;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;


class DashboardExportController extends Controller
{


    private function merchant()
    {

        return Merchant::where(
            'user_id',
            auth()->id()
        )->firstOrFail();

    }



    public function paymentsCsv()
    {

        $merchant = $this->merchant();


        $payments = Payment::where(
            'merchant_id',
            $merchant->id
        )
        ->latest()
        ->get();



        $filename = "paydz-payments.csv";



        $headers = [

            "Content-Type"=>"text/csv",

            "Content-Disposition"=>"attachment; filename=$filename"

        ];



        return response()->streamDownload(function() use($payments){


            $file = fopen('php://output','w');


            fputcsv($file,[

                'ID',
                'Amount',
                'Currency',
                'Status',
                'Date'

            ]);



            foreach($payments as $payment){


                fputcsv($file,[

                    $payment->id,

                    $payment->amount,

                    $payment->currency,

                    $payment->status,

                    $payment->created_at

                ]);


            }


            fclose($file);



        },$filename,$headers);


    }






    public function transactionsCsv()
    {


        $merchant=$this->merchant();



        $transactions=Transaction::where(
            'merchant_id',
            $merchant->id
        )
        ->latest()
        ->get();



        $filename="paydz-transactions.csv";



        return response()->streamDownload(function() use($transactions){


            $file=fopen('php://output','w');



            fputcsv($file,[

                'ID',
                'Amount',
                'Status',
                'Date'

            ]);




            foreach($transactions as $transaction){


                fputcsv($file,[

                    $transaction->id,

                    $transaction->amount,

                    $transaction->status,

                    $transaction->created_at

                ]);

            }



            fclose($file);



        },$filename,[

            "Content-Type"=>"text/csv"

        ]);


    }





    public function pdf()
    {


        $merchant=$this->merchant();



        $payments=Payment::where(
            'merchant_id',
            $merchant->id
        )
        ->latest()
        ->take(20)
        ->get();



        $pdf=Pdf::loadView(
            'exports.dashboard',
            compact(
                'merchant',
                'payments'
            )
        );



        return $pdf->download(
            'paydz-dashboard-report.pdf'
        );


    }



}
