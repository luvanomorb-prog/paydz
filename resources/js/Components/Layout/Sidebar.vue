<script setup>
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()

const menu = [
    {
        title: 'Dashboard',
        url: '/dashboard',
    },
    {
        title: 'Payments',
        url: '/payments',
    },
    {
        title: 'Transactions',
        url: '/transactions',
    },
    {
        title: 'Customers',
        url: '/customers',
    },
    {
        title: 'API Keys',
        url: '/api-keys',
    },
    {
        title: 'Developers',
        url: '/developers',
    },
    {
        title: 'Settings',
        url: '/settings',
    },
]
</script>

<template>

<aside class="w-72 bg-slate-900 text-white flex flex-col">

    <div class="p-8 border-b border-slate-700">

        <h1 class="text-3xl font-bold">
            PayDZ
        </h1>

        <p class="text-slate-400 mt-2">
            Payment Platform
        </p>

    </div>

    <nav class="flex-1 mt-6">

        <Link
            v-for="item in menu"
            :key="item.url"
            :href="item.url"
            class="block px-8 py-4 transition hover:bg-slate-800"
            :class="{
                'bg-slate-800 border-r-4 border-blue-500':
                    page.url === item.url
            }"
        >
            {{ item.title }}
        </Link>

    </nav>

    <div class="p-8 border-t border-slate-700">

        <div class="text-sm text-slate-400">
            PayDZ Platform
        </div>

        <div class="mt-2 font-bold">
            v1.0
        </div>

    </div>

</aside>

</template>
