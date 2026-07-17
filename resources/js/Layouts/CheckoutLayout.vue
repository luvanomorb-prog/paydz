<script setup>
defineProps({
    title: {
        type: String,
        default: 'PayDZ'
    }
})
</script>

<template>
<div
class="min-h-screen bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 text-white">

<slot/>

</div>
</template>
