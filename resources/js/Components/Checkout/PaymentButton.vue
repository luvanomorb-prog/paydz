<script setup>

defineProps({

loading:Boolean

})

</script>

<template>

<button

class="
w-full
py-5
rounded-2xl
bg-gradient-to-r
from-cyan-500
to-blue-700
font-bold
text-xl
shadow-xl
hover:scale-[1.02]
duration-300">

<span v-if="!loading">

Pay Securely

</span>

<span v-else>

Processing...

</span>

</button>

</template>
