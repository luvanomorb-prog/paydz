<script setup>

import {ref} from 'vue'
import {router} from '@inertiajs/vue3'


const props = defineProps({

link:Object

})


const method = ref('baridimob')


const name = ref('')
const email = ref('')



function pay(){


router.post(

'/checkout/'+props.link.public_id+'/pay',

{

name:name.value,

email:email.value,

method:method.value


}

)


}



</script>



<template>


<div class="min-h-screen bg-gray-100 flex justify-center">


<div class="bg-white p-8 mt-10 rounded shadow w-96">


<h1 class="text-2xl font-bold">

{{link.merchant.business_name}}

</h1>



<p class="mt-4">

{{link.description}}

</p>


<h2 class="text-xl mt-3">

{{link.amount}} DZD

</h2>



<input
v-model="name"
placeholder="Name"
class="border p-2 w-full mt-5"
/>



<input
v-model="email"
placeholder="Email"
class="border p-2 w-full mt-3"
/>



<select
v-model="method"
class="border p-2 w-full mt-3"
>


<option value="baridimob">
BaridiMob
</option>


<option value="qr">
QR Code
</option>


</select>



<button
@click="pay"
class="bg-black text-white w-full p-3 mt-5 rounded"
>

Pay

</button>


</div>


</div>


</template>
