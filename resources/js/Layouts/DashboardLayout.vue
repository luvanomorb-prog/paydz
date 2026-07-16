<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>

<div class="min-h-screen bg-gray-100">

    <aside class="fixed left-0 top-0 w-64 h-screen bg-slate-900 text-white">

        <div class="p-6 text-2xl font-bold border-b border-slate-700">
            PayDZ
        </div>

        <nav class="p-4 space-y-2">

            <Link
                href="/dashboard"
                class="block px-4 py-3 rounded-lg hover:bg-slate-800"
            >
                Dashboard
            </Link>

            <Link
                href="/payments"
                class="block px-4 py-3 rounded-lg hover:bg-slate-800"
            >
                Payments
            </Link>

            <Link
                href="/profile"
                class="block px-4 py-3 rounded-lg hover:bg-slate-800"
            >
                Profile
            </Link>

        </nav>

    </aside>

    <main class="ml-64 p-8">

        <slot />

    </main>

</div>

</template>
