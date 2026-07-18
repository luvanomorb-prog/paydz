<script setup>

import { Head } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'



const props = defineProps({

    stats:Object

})



const cards = [

    {
        title:'Users',
        value:props.stats.users,
        icon:'👥'
    },


    {
        title:'Merchants',
        value:props.stats.merchants,
        icon:'🏪'
    },


    {
        title:'Pending Merchants',
        value:props.stats.pending_merchants,
        icon:'⏳'
    },


    {
        title:'Verified Merchants',
        value:props.stats.verified_merchants,
        icon:'✅'
    },


    {
        title:'Payments',
        value:props.stats.payments,
        icon:'💳'
    },


    {
        title:'Revenue',
        value:new Intl.NumberFormat(
            'fr-DZ',
            {
                style:'currency',
                currency:'DZD'
            }
        ).format(props.stats.revenue),
        icon:'💰'
    }


]


</script>




<template>


<Head title="Admin Dashboard"/>



<DashboardLayout>


<div class="space-y-8">



<div>

<h1 class="text-3xl font-bold text-slate-900 dark:text-white">

PayDZ Admin Dashboard

</h1>


<p class="text-slate-500 mt-2">

Platform management overview

</p>


</div>







<div
class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6"
>



<div

v-for="card in cards"

:key="card.title"

class="bg-white dark:bg-slate-900 rounded-2xl shadow border dark:border-slate-800 p-6"

>



<div class="flex justify-between items-center">


<div>


<p class="text-sm text-slate-500">

{{ card.title }}

</p>



<h2 class="text-3xl font-bold mt-3 dark:text-white">

{{ card.value }}

</h2>


</div>



<div
class="text-4xl"
>

{{ card.icon }}

</div>



</div>



</div>



</div>






</div>


</DashboardLayout>


</template>
