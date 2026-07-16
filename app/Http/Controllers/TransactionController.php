<?php

namespace App\Http\Controllers;

use App\Services\TransactionService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransactionController extends Controller
{
    protected TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index(Request $request)
    {
        $transactions = $this->transactionService->getTransactions(
            $request->all()
        );

        return Inertia::render('Transactions/Index', [
            'transactions' => $transactions
        ]);
    }

    public function show($id)
    {
        $transaction = $this->transactionService->find($id);

        return Inertia::render('Transactions/Show', [
            'transaction' => $transaction
        ]);
    }
}
