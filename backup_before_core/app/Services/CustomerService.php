<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Merchant;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CustomerService
{
    /**
     * List customers.
     */
    public function list(array $filters = []): LengthAwarePaginator
    {
        $merchant = Merchant::where('user_id', auth()->id())
            ->firstOrFail();

        $query = Customer::query()
            ->where('merchant_id', $merchant->id);

        if (!empty($filters['search'])) {

            $search = trim($filters['search']);

            $query->where(function ($query) use ($search) {

                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");

            });

        }

        return $query
            ->latest()
            ->paginate(15)
            ->withQueryString();
    }

    /**
     * Find customer.
     */
    public function find(string $id): Customer
    {
        $merchant = Merchant::where('user_id', auth()->id())
            ->firstOrFail();

        return Customer::where('merchant_id', $merchant->id)
            ->findOrFail($id);
    }

    /**
     * Create customer.
     */
    public function create(array $data): Customer
    {
        $merchant = Merchant::where('user_id', auth()->id())
            ->firstOrFail();

        return Customer::create([
            'merchant_id' => $merchant->id,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
        ]);
    }

    /**
     * Update customer.
     */
    public function update(string $id, array $data): Customer
    {
        $customer = $this->find($id);

        $customer->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
        ]);

        return $customer->refresh();
    }

    /**
     * Delete customer.
     */
    public function delete(string $id): void
    {
        $this->find($id)->delete();
    }

    /**
     * Dashboard statistics.
     */
    public function stats(): array
    {
        $merchant = Merchant::where('user_id', auth()->id())
            ->firstOrFail();

        $customers = Customer::where('merchant_id', $merchant->id);

        return [
            'total' => (clone $customers)->count(),
            'today' => (clone $customers)->whereDate('created_at', today())->count(),
            'week' => (clone $customers)->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'month' => (clone $customers)->whereMonth('created_at', now()->month)->count(),
        ];
    }
}
