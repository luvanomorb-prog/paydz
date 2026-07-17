<script setup>
import { Bell, Search } from 'lucide-vue-next'
import { Link } from '@inertiajs/vue3'
</script>

<template>
    <header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-8">

        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                Dashboard
            </h1>

            <p class="text-sm text-gray-500">
                Welcome back to PayDZ
            </p>
        </div>

        <div class="flex items-center gap-5">

            <div class="relative">

                <Search
                    class="absolute left-3 top-3 w-5 h-5 text-gray-400"
                />

                <input
                    type="text"
                    placeholder="Search..."
                    class="w-80 rounded-xl border border-gray-300 pl-10 pr-4 py-3 focus:ring-2 focus:ring-blue-600 outline-none"
                />

            </div>

            <button
                class="relative p-3 rounded-xl bg-gray-100 hover:bg-gray-200"
            >
                <Bell class="w-5 h-5" />

                <span
                    class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full"
                ></span>
            </button>

            <div class="flex items-center gap-3">

                <img
                    src="https://ui-avatars.com/api/?name=PayDZ"
                    class="w-11 h-11 rounded-full"
                />

                <div>

                    <div class="font-semibold">
                        Merchant
                    </div>

                    <div class="text-xs text-gray-500">
                        Verified
                    </div>

                </div>

            </div>

        </div>

    </header>
</template>
