<script setup>
import { ref } from 'vue'
import { Head } from '@inertiajs/vue3'
import axios from 'axios'

import CheckoutLayout from '@/Layouts/CheckoutLayout.vue'
import OrderSummary from '@/Components/Checkout/OrderSummary.vue'
import PaymentMethodCard from '@/Components/Checkout/PaymentMethodCard.vue'

const props = defineProps({
    session: Object
})

const selectedMethod = ref(props.session.payment?.method ?? null)

const loading = ref(false)
const success = ref(false)
const error = ref('')
const transaction = ref(null)

async function pay() {

    if (!selectedMethod.value) {
        error.value = 'Please select a payment method.'
        return
    }

    loading.value = true
    error.value = ''

    try {

        const { data } = await axios.post(
            `/api/v1/checkout/${props.session.session_id}/pay`,
            {
                payment_method: selectedMethod.value
            }
        )

        success.value = true
        transaction.value = data.data

    } catch (e) {

        error.value =
            e.response?.data?.message ??
            'Payment failed.'

    }

    loading.value = false
}
</script>

<template>

<CheckoutLayout title="Secure Checkout">

<Head title="Secure Checkout" />

<div class="grid gap-8 lg:grid-cols-2">

    <OrderSummary
        :session="session"
    />

    <div
        class="rounded-3xl bg-white p-8 shadow-lg border border-slate-200"
    >

        <template v-if="!success">

            <h2 class="text-2xl font-bold mb-6">

                Choose payment method

            </h2>

            <div class="space-y-4">

                <PaymentMethodCard
                    value="cib"
                    title="CIB Card"
                    description="Pay securely using your CIB card."
                    icon="💳"
                    :selected="selectedMethod==='cib'"
                    :disabled="loading"
                    @select="selectedMethod=$event"
                />

                <PaymentMethodCard
                    value="edahabia"
                    title="Edahabia"
                    description="Pay with your Algérie Poste card."
                    icon="🟡"
                    :selected="selectedMethod==='edahabia'"
                    :disabled="loading"
                    @select="selectedMethod=$event"
                />

                <PaymentMethodCard
                    value="baridimob"
                    title="BaridiMob"
                    description="Instant payment from BaridiMob."
                    icon="📱"
                    :selected="selectedMethod==='baridimob'"
                    :disabled="loading"
                    @select="selectedMethod=$event"
                />

            </div>

            <button

                @click="pay"

                :disabled="loading"

                class="mt-8 w-full rounded-2xl bg-blue-600 py-4 text-lg font-bold text-white transition hover:bg-blue-700 disabled:opacity-60"

            >

                <span v-if="loading">

                    Processing Payment...

                </span>

                <span v-else>

                    Pay Now

                </span>

            </button>

            <p
                v-if="error"
                class="mt-5 text-center text-red-600"
            >
                {{ error }}
            </p>

        </template>

        <template v-else>

            <div class="py-10 text-center">

                <div class="text-7xl">

                    ✅

                </div>

                <h2 class="mt-6 text-3xl font-bold text-green-600">

                    Payment Successful

                </h2>

                <p class="mt-3 text-slate-500">

                    Your payment has been processed successfully.

                </p>

                <div
                    class="mt-8 rounded-2xl bg-slate-100 p-5"
                >

                    <p class="text-sm text-slate-500">

                        Transaction ID

                    </p>

                    <p
                        class="mt-2 break-all font-mono"
                    >
                        {{ transaction.transaction_id }}
                    </p>

                </div>

            </div>

        </template>

    </div>

</div>

</CheckoutLayout>

</template>
