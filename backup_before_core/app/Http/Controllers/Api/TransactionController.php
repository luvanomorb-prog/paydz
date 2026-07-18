<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function index(Request $request)
    {

        $transactions = Transaction::query()
            ->latest()
            ->paginate(
                $request->get('limit',15)
            );


        return TransactionResource::collection(
            $transactions
        );

    }



    public function show(Transaction $transaction)
    {

        return new TransactionResource(
            $transaction
        );

    }

}
