<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
<header
class="fixed top-0 left-0 right-0 z-50 border-b border-white/10 backdrop-blur-xl bg-black/40">

<div class="max-w-7xl mx-auto px-8">

<div class="h-20 flex items-center justify-between">

<div class="flex items-center gap-3">

<div
class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-400 to-green-600 flex items-center justify-center shadow-lg">

<span class="text-black font-black text-xl">
P
</span>

</div>

<div>

<h1 class="text-2xl font-black tracking-tight text-white">

Pay<span class="text-emerald-400">DZ</span>

</h1>

<p class="text-xs text-zinc-400">
Payment Infrastructure
</p>

</div>

</div>

<nav class="hidden lg:flex items-center gap-10">

<a href="#" class="text-zinc-300 hover:text-white transition">
Products
</a>

<a href="#" class="text-zinc-300 hover:text-white transition">
Developers
</a>

<a href="#" class="text-zinc-300 hover:text-white transition">
Pricing
</a>

<a href="#" class="text-zinc-300 hover:text-white transition">
Documentation
</a>

</nav>

<div class="flex gap-3">

<Link
href="/login"
class="px-5 py-2 rounded-xl border border-zinc-700 text-white hover:bg-zinc-800 transition">

Sign in

</Link>

<Link
href="/register"
class="px-5 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-black font-bold transition">

Start now

</Link>

</div>

</div>

</div>

</header>
</template>
