<script setup>

const props = defineProps({

    value: String,

    title: String,

    description: String,

    icon: String,

    selected: Boolean,

    disabled: {
        type: Boolean,
        default: false
    }

})

const emit = defineEmits([
    'select'
])

</script>

<template>

<button

    @click="emit('select', value)"

    :disabled="disabled"

    class="w-full rounded-2xl border p-5 transition-all duration-200 text-left"

    :class="[
        selected
            ? 'border-blue-600 bg-blue-50 ring-2 ring-blue-200'
            : 'border-slate-200 bg-white hover:border-blue-400 hover:shadow-lg',
        disabled
            ? 'opacity-60 cursor-not-allowed'
            : 'cursor-pointer'
    ]"
>

    <div class="flex items-center justify-between">

        <div class="flex items-center gap-4">

            <div
                class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-3xl"
            >
                {{ icon }}
            </div>

            <div>

                <h3
                    class="text-lg font-bold text-slate-900"
                >
                    {{ title }}
                </h3>

                <p
                    class="mt-1 text-sm text-slate-500"
                >
                    {{ description }}
                </p>

            </div>

        </div>

        <div
            v-if="selected"
            class="text-3xl text-blue-600"
        >
            ✓
        </div>

    </div>

</button>

</template>
