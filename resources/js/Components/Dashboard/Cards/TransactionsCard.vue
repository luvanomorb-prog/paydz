<script setup>
const props = defineProps({
    total: {
        type: Number,
        default: 0,
    },
    pending: {
        type: Number,
        default: 0,
    },
    failed: {
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
                    Transactions
                </p>

                <h2 class="mt-2 text-3xl font-bold dark:text-white">
                    {{ total }}
                </h2>

                <div class="mt-4 flex gap-4 text-xs">

                    <span class="text-yellow-600">
                        Pending {{ pending }}
                    </span>

                    <span class="text-red-600">
                        Failed {{ failed }}
                    </span>

                </div>

            </div>

            <div class="h-14 w-14 rounded-2xl bg-violet-500 flex items-center justify-center text-white text-2xl">
                📊
            </div>

        </div>

    </div>
</template>
