<script setup>

defineProps({

number:{
default:'**** **** **** 4589'
},

holder:{
default:'PAYDZ CUSTOMER'
},

expiry:{
default:'12/30'
}

})

</script>

<template>

<div
class="relative group perspective">

<div
class="duration-500 preserve-3d group-hover:rotate-y-6">

<div

class="
relative

h-60

rounded-3xl

overflow-hidden

bg-gradient-to-br

from-slate-900

via-blue-900

to-cyan-700

shadow-[0_30px_80px_rgba(0,0,0,.45)]

border

border-white/10

p-8">

<div
class="absolute
top-0
right-0
w-60
h-60
rounded-full
bg-white/10
blur-3xl">
</div>

<div
class="flex
justify-between">

<h2
class="font-bold
text-3xl">

PayDZ

</h2>

<div
class="
w-16
h-12
rounded-xl
bg-white/20
backdrop-blur">
</div>

</div>

<div class="mt-10">

<p
class="
tracking-[5px]
text-3xl
font-semibold">

{{ number }}

</p>

</div>

<div
class="mt-10
flex
justify-between">

<div>

<p class="text-xs opacity-70">

CARD HOLDER

</p>

<p>

{{ holder }}

</p>

</div>

<div>

<p class="text-xs opacity-70">

EXPIRES

</p>

<p>

{{ expiry }}

</p>

</div>

</div>

</div>

</div>

</div>

</template>

<style scoped>

.perspective{

perspective:1500px;

}

.preserve-3d{

transform-style:preserve-3d;

}

.rotate-y-6{

transform:rotateY(12deg);

}

</style>
