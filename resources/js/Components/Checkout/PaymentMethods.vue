<script setup>

import {ref} from 'vue'

const selected=ref('cib')

</script>

<template>

<div class="space-y-4">

<h2
class="font-bold
text-xl">

Payment Method

</h2>

<label
class="
flex
items-center
justify-between
rounded-2xl
border
border-white/10
bg-white/5
p-5
cursor-pointer">

<div class="flex items-center gap-4">

<div class="text-3xl">

💳

</div>

<div>

<h3>CIB Card</h3>

<p class="text-gray-400 text-sm">

Interbank Card

</p>

</div>

</div>

<input
type="radio"
value="cib"
v-model="selected">

</label>

<label
class="
flex
items-center
justify-between
rounded-2xl
border
border-white/10
bg-white/5
p-5
cursor-pointer">

<div class="flex items-center gap-4">

<div class="text-3xl">

🏦

</div>

<div>

<h3>Edahabia</h3>

<p class="text-gray-400 text-sm">

Algérie Poste

</p>

</div>

</div>

<input
type="radio"
value="edahabia"
v-model="selected">

</label>

<label
class="
flex
items-center
justify-between
rounded-2xl
border
border-white/10
bg-white/5
p-5
cursor-pointer">

<div class="flex items-center gap-4">

<div class="text-3xl">

📱

</div>

<div>

<h3>BaridiMob</h3>

<p class="text-gray-400 text-sm">

QR Payment

</p>

</div>

</div>

<input
type="radio"
value="baridimob"
v-model="selected">

</label>

</div>

</template>
