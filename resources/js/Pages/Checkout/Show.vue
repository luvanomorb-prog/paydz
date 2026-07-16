<script setup>

defineProps({

    checkout:Object

});

</script>


<template>

<div class="min-h-screen bg-gray-100 flex items-center justify-center">


<div class="bg-white w-full max-w-md rounded-2xl shadow p-8">


<h1 class="text-2xl font-bold mb-4">
PayDZ Checkout
</h1>


<div class="mb-6">

<h2 class="font-semibold">
{{checkout.product_name}}
</h2>


<p class="text-gray-500">
{{checkout.description}}
</p>

</div>



<div class="border rounded-xl p-4 mb-6">

<p>
Payment ID:
</p>

<strong>
{{checkout.payment_id}}
</strong>

</div>



<button
class="w-full bg-black text-white py-3 rounded-xl">

Continue Payment

</button>


</div>


</div>

</template>
