<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'

defineProps({
    transactions:Object
})
</script>


<template>

<DashboardLayout>

<div class="p-6">

<h1 class="text-2xl font-bold mb-6">
Transactions
</h1>


<div class="bg-white rounded-xl shadow">

<table class="w-full">

<thead>
<tr class="border-b">

<th class="p-4 text-left">
ID
</th>

<th class="p-4">
Amount
</th>

<th class="p-4">
Method
</th>

<th class="p-4">
Status
</th>

<th class="p-4">
Date
</th>

</tr>
</thead>


<tbody>

<tr
v-for="tx in transactions.data"
:key="tx.id"
class="border-b"
>

<td class="p-4">
#{{tx.id}}
</td>


<td class="p-4">
{{tx.amount}} DZD
</td>


<td class="p-4">
{{tx.method}}
</td>


<td class="p-4">

<span>
{{tx.status}}
</span>

</td>


<td class="p-4">
{{tx.created_at}}
</td>


</tr>

</tbody>


</table>

</div>

</div>

</DashboardLayout>

</template>
