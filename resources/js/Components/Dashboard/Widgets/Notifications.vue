<script setup>

defineProps({
    notifications:{
        type:Array,
        default:()=>[]
    }
})

</script>


<template>

<div class="rounded-2xl bg-white dark:bg-slate-900 border dark:border-slate-800 shadow-sm p-6">


<h2 class="text-lg font-bold text-slate-900 dark:text-white mb-5">
Notifications
</h2>


<div v-if="notifications.length">

<div
v-for="item in notifications"
:key="item.id"
class="py-3 border-b dark:border-slate-700 text-sm text-slate-700 dark:text-slate-300"
>
{{ item.message ?? 'New notification' }}
</div>

</div>


<div v-else class="text-slate-400">
No notifications
</div>


</div>

</template>
