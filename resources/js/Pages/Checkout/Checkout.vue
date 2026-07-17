<script setup>

import CheckoutLayout from '@/Layouts/CheckoutLayout.vue'

import AnimatedBackground from '@/Components/Checkout/AnimatedBackground.vue'

import MerchantInfo from '@/Components/Checkout/MerchantInfo.vue'

import PaymentCard from '@/Components/Checkout/PaymentCard.vue'

import PaymentMethods from '@/Components/Checkout/PaymentMethods.vue'

import OrderSummary from '@/Components/Checkout/OrderSummary.vue'

import SecurityBadge from '@/Components/Checkout/SecurityBadge.vue'

import PaymentButton from '@/Components/Checkout/PaymentButton.vue'

import GlassCard from '@/Components/UI/GlassCard.vue'

import { ref } from 'vue'

const loading = ref(false)

const amount = ref(10000)

</script>

<template>

<CheckoutLayout>

<AnimatedBackground/>

<div
class="container mx-auto px-6 py-12">

<div

class="
grid
xl:grid-cols-2
gap-12
items-start">

<!-- LEFT -->

<div class="space-y-8">

<MerchantInfo/>

<PaymentCard/>

<SecurityBadge/>

</div>

<!-- RIGHT -->

<div>

<GlassCard>

<div class="space-y-8">

<OrderSummary
:amount="amount"/>

<PaymentMethods/>

<PaymentButton
:loading="loading"/>

</div>

</GlassCard>

</div>

</div>

</div>

</CheckoutLayout>

</template>
