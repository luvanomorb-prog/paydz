<script setup>
import { Head, Link } from '@inertiajs/vue3'
</script>

<template>

<Head title="PayDZ - Payment Platform"/>

<div class="min-h-screen bg-[#050505] text-white">

<!-- Navbar -->
<nav class="flex justify-between items-center px-10 py-6">

<div class="text-3xl font-bold">
<span class="text-green-400">Pay</span>DZ
</div>


<div class="space-x-8 text-gray-300">

<a href="#">Solutions</a>
<a href="#">Developers</a>
<a href="#">Pricing</a>

<Link
href="/login"
class="px-5 py-2 rounded-xl border border-gray-700">
Login
</Link>

</div>

</nav>


<!-- Hero -->

<section class="px-10 pt-20 grid md:grid-cols-2 gap-10">


<div>


<h1 class="text-6xl font-bold leading-tight">

The payment infrastructure
<br>

for Algeria's digital economy

</h1>


<p class="text-xl text-gray-400 mt-8 max-w-xl">

Accept online payments with CIB cards,
BaridiMob and modern payment technology.
Built for Algerian businesses.

</p>


<div class="mt-10 flex gap-5">


<button
class="bg-green-400 text-black px-8 py-4 rounded-2xl font-bold text-lg">

Start Building

</button>


<button
class="border border-gray-700 px-8 py-4 rounded-2xl">

View Documentation

</button>


</div>

</div>



<!-- Card -->

<div class="flex justify-center">


<div
class="w-[420px] h-[260px]
rounded-3xl
bg-gradient-to-br
from-green-400
to-emerald-700
p-8
text-black
shadow-2xl">


<h2 class="text-3xl font-bold">
PayDZ
</h2>


<p class="mt-10 text-lg">
Payment Intent
</p>


<div class="text-4xl font-bold mt-3">
10,000 DZD
</div>


<div class="mt-8 flex justify-between">

<span>
•••• 4242
</span>

<span>
SUCCESS
</span>

</div>


</div>


</div>


</section>



<!-- Features -->

<section class="px-10 mt-32 grid md:grid-cols-3 gap-8">


<div class="bg-[#111] p-8 rounded-3xl">

<h3 class="text-2xl font-bold">
Fast Payments
</h3>

<p class="text-gray-400 mt-4">
Create payment sessions instantly.
</p>

</div>



<div class="bg-[#111] p-8 rounded-3xl">

<h3 class="text-2xl font-bold">
Developer API
</h3>

<p class="text-gray-400 mt-4">
Integrate PayDZ like Stripe.
</p>

</div>



<div class="bg-[#111] p-8 rounded-3xl">

<h3 class="text-2xl font-bold">
Secure Platform
</h3>

<p class="text-gray-400 mt-4">
Designed for merchants.
</p>

</div>


</section>



<footer class="mt-32 py-10 text-center text-gray-500">

© 2026 PayDZ. All rights reserved.

</footer>


</div>

</template>
