<script setup>
import Sidebar from '@/Components/Dashboard/Sidebar.vue'
import Topbar from '@/Components/Dashboard/Topbar.vue'
</script>

<template>
<div class="min-h-screen bg-slate-100">

    <Sidebar />

    <div class="ml-64">

        <Topbar />

        <main class="p-8">

            <slot />

        </main>

    </div>

</div>
</template>
