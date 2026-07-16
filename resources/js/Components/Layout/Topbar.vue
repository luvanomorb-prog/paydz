<script setup>
import { usePage, Link } from '@inertiajs/vue3'

const page = usePage()
</script>

<template>

<header class="h-20 bg-white border-b flex items-center justify-between px-8">

    <div>

        <h1 class="text-2xl font-bold text-slate-800">
            {{ page.component }}
        </h1>

        <p class="text-sm text-gray-500">
            Welcome to PayDZ Merchant Dashboard
        </p>

    </div>

    <div class="flex items-center gap-6">

        <button class="relative">

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-6 h-6 text-slate-700"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002
                    6.002 0 00-4-5.659V4a2
                    2 0 10-4 0v1.341C7.67
                    6.165 6 8.388 6 11v3.159c0
                    .538-.214 1.055-.595
                    1.436L4 17h5m6
                    0v1a3 3 0 11-6
                    0v-1m6 0H9"
                />
            </svg>

            <span
                class="absolute -top-1 -right-1 w-3 h-3 rounded-full bg-red-500"
            ></span>

        </button>

        <div class="text-right">

            <div class="font-bold">
                {{ page.props.auth.user.name }}
            </div>

            <div class="text-sm text-gray-500">
                {{ page.props.auth.user.email }}
            </div>

        </div>

        <Link
            href="/logout"
            method="post"
            as="button"
            class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700"
        >
            Logout
        </Link>

    </div>

</header>

</template>
