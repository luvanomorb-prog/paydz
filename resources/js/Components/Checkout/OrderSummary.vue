<script setup>

defineProps({

amount:{
default:10000
}

})

</script>

<template>

<div
class="
rounded-3xl
bg-white/5
border
border-white/10
p-6">

<h2
class="font-bold
text-xl
mb-6">

Order Summary

</h2>

<div class="flex justify-between">

<span>

Subtotal

</span>

<span>

{{ amount }} DZD

</span>

</div>

<div
class="flex
justify-between
mt-4">

<span>

Fees

</span>

<span>

0 DZD

</span>

</div>

<hr class="my-6 border-white/10">

<div
class="flex
justify-between
font-bold
text-xl">

<span>

Total

</span>

<span>

{{ amount }} DZD

</span>

</div>

</div>

</template>
