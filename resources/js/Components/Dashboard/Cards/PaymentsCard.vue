<script setup>
const props = defineProps({
    total: {
        type: Number,
        default: 0,
    },
    paid: {
        type: Number,
        default: 0,
    },
})

const percentage = computed(() => {
    if (!props.total) return 0
    return Math.round((props.paid / props.total) * 100)
})
</script>

<script>
import { computed } from 'vue'
export default {}
</script>

<template>
    <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm p-6">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-slate-500">
                    Payments
                </p>

                <h2 class="mt-2 text-3xl font-bold dark:text-white">
                    {{ total }}
                </h2>

                <p class="mt-3 text-sm text-slate-500">
                    {{ paid }} successful
                </p>

            </div>

            <div class="h-14 w-14 rounded-2xl bg-blue-500 text-white flex items-center justify-center text-2xl">
                💳
            </div>

        </div>

        <div class="mt-6">

            <div class="h-2 rounded-full bg-slate-200 dark:bg-slate-700">

                <div
                    class="h-2 rounded-full bg-blue-500 transition-all"
                    :style="{ width: percentage + '%' }"
                ></div>

            </div>

            <div class="mt-2 text-xs text-slate-500">
                {{ percentage }}% Success
            </div>

        </div>

    </div>
</template>
