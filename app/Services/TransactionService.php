<?php

namespace App\Services;

use App\Models\Transaction;

class TransactionService
{
    public function getTransactions(array $filters = [])
    {
        $query = Transaction::query()
            ->latest();

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('id', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('status', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->paginate(15);
    }


    public function find($id)
    {
        return Transaction::findOrFail($id);
    }
}
