<script setup>
const props = defineProps({
    title: String,
    value: [String, Number],
    icon: String,
    color: {
        type: String,
        default: 'emerald',
    },
    change: {
        type: [String, Number],
        default: null,
    },
})

const colors = {
    emerald: 'from-emerald-500 to-green-600',
    blue: 'from-blue-500 to-indigo-600',
    orange: 'from-orange-500 to-amber-600',
    red: 'from-red-500 to-rose-600',
}
</script>

<template>
    <div class="rounded-2xl bg-white dark:bg-slate-900 shadow-sm border border-slate-200 dark:border-slate-800 p-6 transition hover:shadow-xl">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-slate-500">
                    {{ title }}
                </p>

                <h2 class="text-3xl font-bold mt-2 text-slate-900 dark:text-white">
                    {{ value }}
                </h2>

                <p
                    v-if="change"
                    class="mt-3 text-xs text-emerald-600 font-semibold"
                >
                    {{ change }}
                </p>

            </div>

            <div
                class="w-14 h-14 rounded-2xl flex items-center justify-center text-white text-xl bg-gradient-to-br"
                :class="colors[color]"
            >
                {{ icon }}
            </div>

        </div>

    </div>
</template>
