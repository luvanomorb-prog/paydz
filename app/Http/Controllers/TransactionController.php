<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::latest()
            ->paginate(20);

        return Inertia::render('Transactions/Index', [
            'transactions' => $transactions
        ]);
    }


    public function show(Transaction $transaction)
    {
        return Inertia::render('Transactions/Show', [
            'transaction' => $transaction
        ]);
    }
}
