<script setup>

defineProps({

loading:Boolean

})

</script>

<template>

<button

class="

w-full

rounded-2xl

bg-gradient-to-r

from-cyan-500

to-blue-600

py-4

font-bold

text-lg

transition

duration-300

hover:scale-[1.02]

hover:shadow-xl

active:scale-95

disabled:opacity-50">

<slot/>

</button>

</template>

