<script setup>
const props = defineProps({
    rate: {
        type: Number,
        default: 0,
    },
})
</script>

<template>
    <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm p-6">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-slate-500">
                    Success Rate
                </p>

                <h2 class="mt-2 text-3xl font-bold dark:text-white">
                    {{ rate }}%
                </h2>

                <p class="mt-3 text-sm text-emerald-600">
                    Payment performance
                </p>

            </div>

            <div class="h-14 w-14 rounded-2xl bg-emerald-600 flex items-center justify-center text-white text-2xl">
                ✓
            </div>

        </div>

        <div class="mt-6 h-2 rounded-full bg-slate-200 dark:bg-slate-700">

            <div
                class="h-2 rounded-full bg-emerald-500 transition-all duration-500"
                :style="{ width: rate + '%' }"
            ></div>

        </div>

    </div>
</template>
