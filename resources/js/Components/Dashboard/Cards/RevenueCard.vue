<script setup>
import { computed } from 'vue'
import { formatCurrency } from '@/Composables/useCurrency'

const props = defineProps({
    amount: {
        type: Number,
        default: 0,
    },
    growth: {
        type: Number,
        default: 0,
    },
})

const total = computed(() => formatCurrency(props.amount))
</script>

<template>
    <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm p-6">

        <div class="flex items-center justify-between">

            <div>
                <p class="text-sm text-slate-500">
                    Total Revenue
                </p>

                <h2 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">
                    {{ total }}
                </h2>

                <p class="mt-3 text-sm font-medium text-emerald-600">
                    ▲ {{ growth }}%
                </p>
            </div>

            <div class="h-14 w-14 rounded-2xl bg-emerald-500 flex items-center justify-center text-white text-2xl">
                💰
            </div>

        </div>

    </div>
</template>
