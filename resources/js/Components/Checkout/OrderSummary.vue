<script setup>

defineProps({

    session: {
        type: Object,
        required: true
    }

})

</script>

<template>

<div class="rounded-3xl bg-white p-8 shadow-lg border border-slate-200">

    <div class="flex items-center justify-between">

        <div>

            <p class="text-sm text-slate-500">
                Merchant
            </p>

            <h2 class="mt-1 text-2xl font-bold text-slate-900">
                {{ session.merchant.business_name }}
            </h2>

        </div>

        <span
            class="rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-700"
        >
            ✔ Verified
        </span>

    </div>

    <div class="my-8 border-t"></div>

    <div class="space-y-5">

        <div class="flex justify-between">

            <span class="text-slate-500">
                Customer
            </span>

            <span class="font-semibold">
                {{ session.customer_name }}
            </span>

        </div>

        <div class="flex justify-between">

            <span class="text-slate-500">
                Email
            </span>

            <span class="font-semibold">
                {{ session.customer_email }}
            </span>

        </div>

        <div class="flex justify-between">

            <span class="text-slate-500">
                Session
            </span>

            <span
                class="font-mono text-xs"
            >
                {{ session.session_id }}
            </span>

        </div>

        <div class="flex justify-between">

            <span class="text-slate-500">
                Status
            </span>

            <span
                class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-bold uppercase text-yellow-700"
            >
                {{ session.status }}
            </span>

        </div>

    </div>

    <div class="my-8 border-t"></div>

    <div class="flex items-center justify-between">

        <span class="text-lg font-semibold">
            Total
        </span>

        <span
            class="text-4xl font-extrabold text-blue-600"
        >
            {{ session.amount }}
            {{ session.currency }}
        </span>

    </div>

    <div
        class="mt-8 rounded-2xl bg-slate-100 p-4"
    >

        <div class="flex items-center gap-3">

            <div class="text-2xl">

                🔒

            </div>

            <div>

                <p class="font-semibold">

                    Secure Payment

                </p>

                <p class="text-sm text-slate-500">

                    Your payment is encrypted using industry standards.

                </p>

            </div>

        </div>

    </div>

</div>

</template>
