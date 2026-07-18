<script setup>

defineProps({
activities:{
type:Array,
default:()=>[]
}
})

</script>


<template>

<div class="bg-white dark:bg-slate-900 rounded-2xl shadow border dark:border-slate-800 p-6">

<h2 class="font-bold text-lg dark:text-white mb-4">
Activity Feed
</h2>


<div v-if="activities.length">

<div
v-for="item in activities"
:key="item.id"
class="py-3 border-b dark:border-slate-700 text-sm dark:text-white"
>
{{ item.message ?? 'Activity update' }}
</div>

</div>


<div v-else class="text-slate-400">
No recent activity
</div>


</div>

</template>
