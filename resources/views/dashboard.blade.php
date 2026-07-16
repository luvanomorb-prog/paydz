<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            PayDZ Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-gray-500 text-sm">Payments</p>
                    <h2 class="text-3xl font-bold mt-2">
                        {{ $stats['payments'] }}
                    </h2>
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-gray-500 text-sm">Transactions</p>
                    <h2 class="text-3xl font-bold mt-2">
                        {{ $stats['transactions'] }}
                    </h2>
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-gray-500 text-sm">Revenue</p>
                    <h2 class="text-3xl font-bold mt-2">
                        {{ number_format($stats['revenue'],2) }} DZD
                    </h2>
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-gray-500 text-sm">Pending</p>
                    <h2 class="text-3xl font-bold mt-2">
                        {{ $stats['pending'] }}
                    </h2>
                </div>

            </div>

            <div class="bg-white rounded-xl shadow mt-8">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold">
                        Latest Payments
                    </h3>
                </div>

                <table class="w-full">

                    <thead class="bg-gray-100">
                        <tr>
                            <th class="text-left p-4">Payment ID</th>
                            <th class="text-left p-4">Customer</th>
                            <th class="text-left p-4">Amount</th>
                            <th class="text-left p-4">Status</th>
                        </tr>
                    </thead>

                    <tbody>

                    @foreach($payments as $payment)

                        <tr class="border-b">

                            <td class="p-4">
                                {{ $payment->payment_id }}
                            </td>

                            <td class="p-4">
                                {{ $payment->customer_name }}
                            </td>

                            <td class="p-4">
                                {{ number_format($payment->amount,2) }}
                                {{ $payment->currency }}
                            </td>

                            <td class="p-4">
                                {{ ucfirst($payment->status) }}
                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>
            </div>

        </div>
    </div>
</x-app-layout>
