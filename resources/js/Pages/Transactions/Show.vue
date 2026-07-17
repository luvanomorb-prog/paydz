<script setup>
import { Head, Link } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'

defineProps({
    transaction: Object,
})
</script>

<template>

<Head title="Transaction Details" />

<DashboardLayout>

<div class="max-w-7xl mx-auto p-8">

<div class="flex items-center justify-between mb-8">

<div>

<h1 class="text-3xl font-bold">
Transaction Details
</h1>

<p class="text-gray-500 mt-1">
{{ transaction.transaction_id }}
</p>

</div>

<Link
href="/transactions"
class="px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-black"
>
Back
</Link>

</div>

<div class="grid grid-cols-2 gap-6">

<div class="bg-white rounded-xl shadow p-6">

<h2 class="font-bold text-lg mb-6">
Transaction
</h2>

<div class="space-y-4">

<div class="flex justify-between">
<span class="text-gray-500">Transaction ID</span>
<span class="font-mono">{{ transaction.transaction_id }}</span>
</div>

<div class="flex justify-between">
<span class="text-gray-500">Status</span>

<span
class="px-3 py-1 rounded-full text-sm"
:class="{
'bg-yellow-100 text-yellow-700': transaction.status=='pending',
'bg-green-100 text-green-700': transaction.status=='paid',
'bg-red-100 text-red-700': transaction.status=='failed'
}"
>

{{ transaction.status }}

</span>

</div>

<div class="flex justify-between">
<span class="text-gray-500">Amount</span>
<span>{{ transaction.amount }} {{ transaction.currency }}</span>
</div>

<div class="flex justify-between">
<span class="text-gray-500">Created</span>
<span>{{ transaction.created_at }}</span>
</div>

</div>

</div>

<div class="bg-white rounded-xl shadow p-6">

<h2 class="font-bold text-lg mb-6">
Payment
</h2>

<div class="space-y-4">

<div class="flex justify-between">
<span class="text-gray-500">Payment ID</span>
<span>{{ transaction.payment.payment_id }}</span>
</div>

<div class="flex justify-between">
<span class="text-gray-500">Customer</span>
<span>{{ transaction.payment.customer_name }}</span>
</div>

<div class="flex justify-between">
<span class="text-gray-500">Email</span>
<span>{{ transaction.payment.customer_email }}</span>
</div>

<div class="flex justify-between">
<span class="text-gray-500">Description</span>
<span>{{ transaction.payment.description }}</span>
</div>

</div>

</div>

</div>

<div class="bg-white rounded-xl shadow mt-8 p-6">

<h2 class="font-bold text-lg mb-4">
JSON Response
</h2>

<pre class="bg-gray-900 text-green-400 rounded-xl p-6 overflow-auto text-sm">
{{ JSON.stringify(transaction, null, 2) }}
</pre>

</div>

</div>

</DashboardLayout>

</template>
