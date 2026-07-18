<script setup>

import { computed } from 'vue'
import { formatCurrency } from '@/Composables/useCurrency'


const props = defineProps({

    amount:{
        type:Number,
        default:0
    },

    currency:{
        type:String,
        default:'DZD'
    }

})


const total = computed(()=>{

    return formatCurrency(
        props.amount,
        props.currency
    )

})


</script>



<template>

<div
class="rounded-3xl overflow-hidden bg-gradient-to-br from-emerald-500 via-emerald-600 to-green-700 text-white shadow-xl p-8"
>


<p class="uppercase text-sm tracking-widest opacity-80">
Available Balance
</p>



<h2 class="text-4xl font-bold mt-4">
{{ total }}
</h2>



<div class="mt-10 flex items-center justify-between">


<div>

<p class="text-xs opacity-80">
PayDZ Merchant
</p>


<p class="font-semibold mt-1">
Available for payments
</p>


</div>



<div
class="h-14 w-14 rounded-2xl bg-white/20 flex items-center justify-center text-2xl"
>
💳
</div>



</div>


</div>


</template>
