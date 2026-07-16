<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import { ref } from 'vue'

const props = defineProps({
    payments: Object,
    filters: Object,
})

const search = ref(props.filters?.search ?? '')

function doSearch() {
    router.get(
        '/payments',
        {
            search: search.value,
        },
        {
            preserveState: true,
            replace: true,
        }
    )
}
</script>

<template>

<Head title="Payments" />

<DashboardLayout>

<div class="space-y-6">

<div class="flex items-center justify-between">

<div>

<h1 class="text-3xl font-bold">
Payments
</h1>

<p class="text-gray-500">
Manage all merchant payments
</p>

</div>

<input
v-model="search"
@input="doSearch"
type="text"
placeholder="Search payment..."
class="w-80 border rounded-lg px-4 py-2"
/>

</div>

<div class="bg-white rounded-xl shadow overflow-hidden">

<table class="w-full">

<thead class="bg-gray-100">

<tr>

<th class="p-4 text-left">Payment ID</th>
<th class="p-4 text-left">Customer</th>
<th class="p-4 text-left">Amount</th>
<th class="p-4 text-left">Currency</th>
<th class="p-4 text-left">Status</th>
<th class="p-4 text-left"></th>

</tr>

</thead>

<tbody>

<tr
v-for="payment in payments.data"
:key="payment.id"
class="border-b hover:bg-gray-50"
>

<td class="p-4 font-mono">

{{ payment.payment_id }}

</td>

<td class="p-4">

{{ payment.customer_name }}

</td>

<td class="p-4">

{{ payment.amount }}

</td>

<td class="p-4">

{{ payment.currency }}

</td>

<td class="p-4">

<span
:class="{
'bg-yellow-100 text-yellow-700': payment.status==='pending',
'bg-green-100 text-green-700': payment.status==='paid',
'bg-red-100 text-red-700': payment.status==='failed'
}"
class="px-3 py-1 rounded-full"
>

{{ payment.status }}

</span>

</td>

<td class="p-4">

<Link
:href="`/payments/${payment.payment_id}`"
class="text-indigo-600 hover:underline"
>

View

</Link>

</td>

</tr>

<tr v-if="payments.data.length===0">

<td colspan="6" class="text-center p-8 text-gray-400">

No payments found.

</td>

</tr>

</tbody>

</table>

</div>

<div class="flex justify-center gap-2">

<Link
v-for="link in payments.links"
:key="link.label"
:href="link.url || '#'"
v-html="link.label"
class="px-3 py-2 border rounded"
:class="{
'bg-slate-900 text-white':link.active,
'pointer-events-none opacity-50':!link.url
}"
/>

</div>

</div>

</DashboardLayout>

</template>
