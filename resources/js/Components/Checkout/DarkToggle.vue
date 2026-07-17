<template>

<button
@click="toggle"
class="rounded-xl px-4 py-2 bg-slate-800">

🌙

</button>

</template>

<script setup>

const toggle=()=>{

document.documentElement.classList.toggle('dark')

}

</script>
