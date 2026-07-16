<script setup>

defineProps({
    transaction:Object
});

</script>


<template>

<div class="p-6">

<h1 class="text-2xl font-bold mb-6">
Transaction Details
</h1>


<div class="bg-white shadow rounded-xl p-6">


<p>
<strong>ID:</strong>
{{transaction.id}}
</p>


<p>
<strong>Amount:</strong>
{{transaction.amount}}
</p>


<p>
<strong>Status:</strong>
{{transaction.status}}
</p>


<p>
<strong>Created:</strong>
{{transaction.created_at}}
</p>


</div>


</div>

</template>

