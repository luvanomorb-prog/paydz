<script setup>

import DashboardLayout from '@/Layouts/DashboardLayout.vue'


defineProps({

links:Array

})

</script>


<template>

<DashboardLayout>

<div class="p-6">

<h1 class="text-2xl font-bold mb-6">
Payment Links
</h1>


<div class="grid gap-4">


<div
v-for="link in links"
:key="link.id"
class="border rounded-xl p-5"
>


<h2 class="font-bold text-lg">
{{link.title}}
</h2>


<p>
{{link.amount}} {{link.currency}}
</p>


<p>
Views:
{{link.views_count}}
</p>


<p>
Payments:
{{link.payments_count}}
</p>


<p>
Revenue:
{{link.revenue}}
</p>


<p>
Status:
<span v-if="link.active">
Active
</span>

<span v-else>
Disabled
</span>

</p>


<a
:href="'/pay/'+link.public_id"
target="_blank"
class="text-blue-600"
>
Open payment page
</a>


</div>


</div>


</div>

</DashboardLayout>

</template>
