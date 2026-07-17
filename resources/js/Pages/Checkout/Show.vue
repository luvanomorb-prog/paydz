<script setup>

import {ref} from 'vue'
import axios from 'axios'


const props = defineProps({

paymentLink:Object,

qrCode:String

})


const loading = ref(false)



function pay(){


loading.value=true


axios.post(
'/pay/'+props.paymentLink.public_id+'/process'
)
.then(res=>{


alert(
'Payment started'
)


})
.finally(()=>{

loading.value=false

})


}



</script>



<template>


<div class="min-h-screen bg-gray-100 flex items-center justify-center p-5">


<div class="bg-white rounded-3xl shadow-xl w-full max-w-md p-8">


<h1 class="text-2xl font-bold text-center">

{{paymentLink.title}}

</h1>



<p class="text-gray-500 text-center mt-3">

{{paymentLink.description}}

</p>



<div class="text-center mt-6">


<span class="text-4xl font-bold">

{{paymentLink.amount}}

</span>


<span class="ml-2">

{{paymentLink.currency}}

</span>


</div>




<div class="flex justify-center mt-8">


<img
:src="'data:image/png;base64,'+qrCode"
class="w-48 h-48"
/>


</div>




<button

@click="pay"

:disabled="loading"

class="mt-8 w-full bg-black text-white py-4 rounded-xl text-lg"

>


<span v-if="!loading">

Pay Now

</span>


<span v-else>

Processing...

</span>


</button>




<div class="text-center mt-5 text-sm text-gray-400">

Secured by PayDZ

</div>



</div>


</div>



</template>
