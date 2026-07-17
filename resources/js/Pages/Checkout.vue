<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import QRCode from 'qrcode.vue'


const props = defineProps({

    paymentLink:Object

})


const form = useForm({

    payment_link_id: props.paymentLink.id,

})


function pay(){

    form.post(
        `/pay/${props.paymentLink.public_id}/process`,
        {

            preserveScroll:true

        }

    )

}


const checkoutUrl = window.location.href


</script>



<template>

<Head title="Secure Checkout" />


<div class="min-h-screen bg-gray-100 flex items-center justify-center p-6">


<div class="bg-white rounded-3xl shadow-xl w-full max-w-md p-8">


<!-- Logo -->

<div class="text-center mb-6">

<h1 class="text-2xl font-bold">
PayDZ
</h1>

<p class="text-gray-500">
Secure Payment
</p>

</div>



<!-- Product -->

<div class="border rounded-xl p-5 mb-6">


<h2 class="text-xl font-semibold">

{{ paymentLink.title }}

</h2>


<p class="text-gray-500 mt-2">

{{ paymentLink.description }}

</p>



<div class="text-4xl font-bold mt-5">

{{ paymentLink.amount }}

{{ paymentLink.currency }}

</div>


</div>





<!-- QR CODE -->


<div class="flex justify-center mb-6">


<QRCode

:value="checkoutUrl"

:size="180"

/>


</div>



<p class="text-center text-gray-500 text-sm mb-6">

Scan QR Code to pay

</p>





<!-- Payment Button -->


<button

@click="pay"

:disabled="form.processing"

class="w-full bg-black text-white py-4 rounded-xl text-lg font-bold hover:bg-gray-800"


>


<span v-if="!form.processing">

Pay Now

</span>


<span v-else>

Processing...

</span>


</button>



</div>


</div>


</template>
