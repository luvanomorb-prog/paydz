<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import {
    LayoutDashboard,
    CreditCard,
    Wallet,
    Link as LinkIcon,
    Users,
    KeyRound,
    Bell,
    Settings,
    LogOut
} from 'lucide-vue-next'

const page = usePage()

const menus = [
    { name: 'Dashboard', href: '/dashboard', icon: LayoutDashboard },
    { name: 'Payments', href: '/payments', icon: CreditCard },
    { name: 'Transactions', href: '/transactions', icon: Wallet },
    { name: 'Payment Links', href: '/payment-links', icon: LinkIcon },
    { name: 'Customers', href: '/customers', icon: Users },
    { name: 'API Keys', href: '/settings/api-keys', icon: KeyRound },
    { name: 'Webhooks', href: '/settings/webhooks', icon: Bell },
    { name: 'Settings', href: '/profile', icon: Settings },
]
</script>

<template>

<aside class="fixed left-0 top-0 w-64 h-screen bg-slate-900 text-white flex flex-col">

    <div class="h-20 flex items-center justify-center border-b border-slate-700">

        <h1 class="text-3xl font-extrabold tracking-wide">
            PayDZ
        </h1>

    </div>

    <nav class="flex-1 p-5 space-y-2">

        <Link
            v-for="item in menus"
            :key="item.name"
            :href="item.href"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition hover:bg-slate-800"
            :class="{
                'bg-emerald-600 text-white': page.url.startsWith(item.href)
            }"
        >
            <component :is="item.icon" class="w-5 h-5" />

            {{ item.name }}

        </Link>

    </nav>

    <div class="border-t border-slate-700 p-5">

        <button
            class="flex items-center gap-3 w-full px-4 py-3 rounded-xl bg-red-600 hover:bg-red-700 transition"
        >
            <LogOut class="w-5 h-5" />

            Logout

        </button>

    </div>

</aside>

</template>
