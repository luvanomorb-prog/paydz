<script setup>

const actions = [

    {
        title:'Export Payments CSV',
        description:'Download all payments',
        url:'/dashboard/export/payments',
        icon:'💳'
    },


    {
        title:'Export Transactions CSV',
        description:'Download transactions history',
        url:'/dashboard/export/transactions',
        icon:'📊'
    },


    {
        title:'Download PDF Report',
        description:'Generate dashboard report',
        url:'/dashboard/export/pdf',
        icon:'📄'
    }

]


function open(url){

    window.location.href=url

}

</script>



<template>


<div
class="bg-white dark:bg-slate-900 rounded-2xl shadow border dark:border-slate-800 p-6"
>



<h2 class="text-lg font-bold dark:text-white mb-5">

Quick Actions

</h2>




<div
class="grid grid-cols-1 md:grid-cols-3 gap-4"
>




<button

v-for="item in actions"

:key="item.title"

@click="open(item.url)"

class="text-left p-5 rounded-xl border dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 transition"

>


<div class="text-3xl mb-3">

{{ item.icon }}

</div>



<h3 class="font-semibold dark:text-white">

{{ item.title }}

</h3>



<p class="text-sm text-slate-500 mt-1">

{{ item.description }}

</p>



</button>




</div>



</div>



</template>
