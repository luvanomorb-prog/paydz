<script setup>
import { Head } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'

defineProps({
    merchant: Object,
    stats: Object,
    payments: Array,
})
</script>

<template>

<Head title="Dashboard" />

<DashboardLayout>

<div>

    <div class="mb-8">

        <h1 class="text-3xl font-bold text-slate-800">
            Welcome {{ merchant.business_name }}
        </h1>

        <p class="text-gray-500 mt-2">
            Here is an overview of your business.
        </p>

    </div>

    <div class="grid grid-cols-4 gap-6">

        <div class="bg-white rounded-xl shadow p-6">

            <p class="text-gray-500">
                Payments
            </p>

            <h2 class="text-4xl font-bold mt-3">
                {{ stats.payments }}
            </h2>

        </div>

        <div class="bg-white rounded-xl shadow p-6">

            <p class="text-gray-500">
                Transactions
            </p>

            <h2 class="text-4xl font-bold mt-3">
                {{ stats.transactions }}
            </h2>

        </div>

        <div class="bg-white rounded-xl shadow p-6">

            <p class="text-gray-500">
                Revenue
            </p>

            <h2 class="text-4xl font-bold mt-3">
                {{ stats.revenue }} DZD
            </h2>

        </div>

        <div class="bg-white rounded-xl shadow p-6">

            <p class="text-gray-500">
                Pending
            </p>

            <h2 class="text-4xl font-bold mt-3">
                {{ stats.pending }}
            </h2>

        </div>

    </div>

    <div class="bg-white rounded-xl shadow mt-10">

        <div class="p-6 border-b">

            <h2 class="text-xl font-bold">
                Latest Payments
            </h2>

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

                <tr
                    v-for="payment in payments"
                    :key="payment.id"
                    class="border-b"
                >

                    <td class="p-4">
                        {{ payment.payment_id }}
                    </td>

                    <td class="p-4">
                        {{ payment.customer_name }}
                    </td>

                    <td class="p-4">
                        {{ payment.amount }} {{ payment.currency }}
                    </td>

                    <td class="p-4">

                        <span
                            class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700"
                        >
                            {{ payment.status }}
                        </span>

                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</div>

</DashboardLayout>

</template>
