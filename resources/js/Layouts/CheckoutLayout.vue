<script setup>
import { Head } from '@inertiajs/vue3'

defineProps({
    title: {
        type: String,
        default: 'PayDZ Checkout'
    }
})
</script>

<template>

<Head :title="title" />

<div class="min-h-screen bg-slate-100">

    <header class="border-b bg-white shadow-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">

            <div class="flex items-center gap-3">

                <div
                    class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-600 text-xl font-bold text-white"
                >
                    P
                </div>

                <div>

                    <h1 class="text-2xl font-bold text-slate-900">
                        PayDZ
                    </h1>

                    <p class="text-sm text-slate-500">
                        Secure Payment Platform
                    </p>

                </div>

            </div>

            <div
                class="flex items-center gap-2 rounded-full bg-green-100 px-4 py-2 text-sm font-medium text-green-700"
            >
                🔒 SSL Secured
            </div>

        </div>
    </header>

    <main class="mx-auto max-w-7xl px-6 py-10">

        <slot />

    </main>

    <footer class="border-t bg-white py-6">

        <div class="text-center text-sm text-slate-500">

            © {{ new Date().getFullYear() }}

            PayDZ.

            All rights reserved.

        </div>

    </footer>

</div>

</template>
