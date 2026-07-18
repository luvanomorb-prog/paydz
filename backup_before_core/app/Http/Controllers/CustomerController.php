<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CustomerController extends Controller
{
    public function __construct(
        protected CustomerService $customerService
    ) {}

    /**
     * Customers list.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Customers/Index', [

            'customers' => $this->customerService->list(
                $request->only('search')
            ),

            'stats' => $this->customerService->stats(),

            'filters' => [
                'search' => $request->input('search'),
            ],

        ]);
    }

    /**
     * Show customer.
     */
    public function show(string $customer): Response
    {
        return Inertia::render('Customers/Show', [

            'customer' => $this->customerService->find($customer),

        ]);
    }

    /**
     * Create page.
     */
    public function create(): Response
    {
        return Inertia::render('Customers/Create');
    }

    /**
     * Store customer.
     */
    public function store(Request $request)
    {
        $this->customerService->create($request->all());

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer created successfully.');
    }

    /**
     * Edit page.
     */
    public function edit(string $customer): Response
    {
        return Inertia::render('Customers/Edit', [

            'customer' => $this->customerService->find($customer),

        ]);
    }

    /**
     * Update customer.
     */
    public function update(Request $request, string $customer)
    {
        $this->customerService->update(
            $customer,
            $request->all()
        );

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    /**
     * Delete customer.
     */
    public function destroy(string $customer)
    {
        $this->customerService->delete($customer);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}
