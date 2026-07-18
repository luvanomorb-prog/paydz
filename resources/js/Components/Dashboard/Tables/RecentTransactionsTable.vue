<script setup>

import { router } from '@inertiajs/vue3'


const props = defineProps({

    transactions:{
        type:Object,
        default:()=>({
            data:[],
            links:[]
        })
    }

})



function go(url){

    if(url){

        router.visit(url,{
            preserveScroll:true,
            preserveState:true
        })

    }

}




function statusClass(status){

    return {

        completed:
        'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',


        paid:
        'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',


        pending:
        'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',


        failed:
        'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'

    }[status]

    ??
    'bg-slate-100 text-slate-600'

}




function formatAmount(amount,currency='DZD'){

    return new Intl.NumberFormat('fr-DZ',{
        style:'currency',
        currency:currency
    }).format(amount ?? 0)

}



</script>




<template>


<div class="bg-white dark:bg-slate-900 rounded-2xl shadow border dark:border-slate-800 overflow-hidden">



<div class="p-6 flex justify-between items-center">


<h2 class="font-bold text-lg dark:text-white">

Recent Transactions

</h2>


<span class="text-sm text-slate-400">

Total: {{ transactions.total ?? 0 }}

</span>



</div>






<div class="overflow-x-auto">


<table class="w-full text-sm">



<thead class="bg-slate-50 dark:bg-slate-800">


<tr class="text-left text-slate-500 dark:text-slate-400">


<th class="p-4">
ID
</th>


<th class="p-4">
Amount
</th>


<th class="p-4">
Status
</th>


<th class="p-4">
Date
</th>


</tr>


</thead>






<tbody>



<tr

v-for="item in transactions.data"

:key="item.id"

class="border-t dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50"

>



<td class="p-4 font-medium dark:text-white">

#{{ item.id }}

</td>




<td class="p-4 dark:text-slate-300">

{{ formatAmount(item.amount,item.currency) }}

</td>




<td class="p-4">


<span

class="px-3 py-1 rounded-full text-xs font-semibold"

:class="statusClass(item.status)"

>

{{ item.status }}

</span>


</td>





<td class="p-4 text-slate-500 dark:text-slate-400">

{{ new Date(item.created_at).toLocaleDateString() }}

</td>




</tr>





<tr v-if="!transactions.data.length">

<td
colspan="4"
class="p-6 text-center text-slate-400"
>

No transactions found

</td>

</tr>




</tbody>


</table>


</div>







<div

class="p-4 border-t dark:border-slate-800 flex flex-wrap gap-2"

>


<button

v-for="link in transactions.links"

:key="link.label"

@click="go(link.url)"

:disabled="!link.url"

class="px-3 py-1 rounded-lg text-sm border dark:border-slate-700"

:class="{

'opacity-40 cursor-not-allowed':!link.url,

'bg-slate-900 text-white dark:bg-white dark:text-slate-900':link.active

}"

v-html="link.label"

>


</button>


</div>




</div>


</template>
