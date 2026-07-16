<script setup>
import { Head, Link } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'

defineProps({
    payment: Object,
})
</script>

<template>
    <Head title="Payment Details" />

    <DashboardLayout>

        <div class="mb-8 flex justify-between items-center">

            <div>
                <h1 class="text-3xl font-bold">
                    Payment Details
                </h1>

                <p class="text-gray-500 mt-2">
                    {{ payment.payment_id }}
                </p>
            </div>

            <Link
                href="/payments"
                class="px-5 py-3 rounded-lg bg-slate-900 text-white"
            >
                Back
            </Link>

        </div>

        <div class="grid grid-cols-2 gap-6">

            <div class="bg-white rounded-xl shadow p-6">

                <h2 class="text-xl font-bold mb-6">
                    Payment
                </h2>

                <div class="space-y-4">

                    <div>
                        <p class="text-gray-500">Payment ID</p>
                        <p class="font-mono">{{ payment.payment_id }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Amount</p>
                        <p>{{ payment.amount }} {{ payment.currency }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Status</p>

                        <span
                            class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700"
                        >
                            {{ payment.status }}
                        </span>

                    </div>

                    <div>
                        <p class="text-gray-500">Description</p>
                        <p>{{ payment.description }}</p>
                    </div>

                </div>

            </div>

            <div class="bg-white rounded-xl shadow p-6">

                <h2 class="text-xl font-bold mb-6">
                    Customer
                </h2>

                <div class="space-y-4">

                    <div>
                        <p class="text-gray-500">Name</p>
                        <p>{{ payment.customer_name }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Email</p>
                        <p>{{ payment.customer_email }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Created</p>
                        <p>{{ payment.created_at }}</p>
                    </div>

                </div>

            </div>

        </div>

    </DashboardLayout>
</template>
