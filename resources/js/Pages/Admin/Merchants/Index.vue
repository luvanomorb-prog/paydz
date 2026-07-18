<script setup>

import { Head, router } from '@inertiajs/vue3'

import DashboardLayout from '@/Layouts/DashboardLayout.vue'

import { ref } from 'vue'



const props = defineProps({

    merchants:Object,

    filters:Object

})



const search = ref(
    props.filters.search ?? ''
)



function submitSearch(){


    router.get(
        '/admin/merchants',
        {
            search:search.value
        },
        {
            preserveState:true,
            preserveScroll:true
        }
    )


}




function action(url){


    router.post(
        url,
        {},
        {
            preserveScroll:true
        }
    )


}




function statusClass(status){


    return {


        verified:
        'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',



        pending:
        'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',



        rejected:
        'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',



        suspended:
        'bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-300'


    }[status]

}




</script>





<template>


<Head title="Merchants Management"/>



<DashboardLayout>



<div class="space-y-8">



<div>


<h1 class="text-3xl font-bold dark:text-white">

Merchants Management

</h1>


<p class="text-slate-500 mt-2">

Review and manage PayDZ merchants

</p>


</div>






<div class="bg-white dark:bg-slate-900 rounded-2xl shadow border dark:border-slate-800 p-6">



<div class="flex gap-3">


<input

v-model="search"

@keyup.enter="submitSearch"

placeholder="Search merchant..."

class="flex-1 rounded-xl border dark:bg-slate-800 dark:border-slate-700 dark:text-white px-4 py-3"

/>



<button

@click="submitSearch"

class="px-6 py-3 rounded-xl bg-slate-900 text-white dark:bg-white dark:text-slate-900"

>

Search

</button>


</div>



</div>








<div class="bg-white dark:bg-slate-900 rounded-2xl shadow border dark:border-slate-800 overflow-hidden">





<div class="overflow-x-auto">


<table class="w-full text-sm">



<thead class="bg-slate-50 dark:bg-slate-800">


<tr class="text-left text-slate-500">


<th class="p-4">
Business
</th>


<th class="p-4">
Email
</th>


<th class="p-4">
Country
</th>


<th class="p-4">
Status
</th>


<th class="p-4">
Actions
</th>


</tr>


</thead>






<tbody>


<tr

v-for="merchant in merchants.data"

:key="merchant.id"

class="border-t dark:border-slate-800"

>


<td class="p-4 dark:text-white font-semibold">

{{ merchant.business_name }}

</td>




<td class="p-4 text-slate-500">

{{ merchant.business_email }}

</td>





<td class="p-4 dark:text-slate-300">

{{ merchant.country }}

</td>





<td class="p-4">


<span

class="px-3 py-1 rounded-full text-xs font-semibold"

:class="statusClass(merchant.status)"

>

{{ merchant.status }}

</span>


</td>






<td class="p-4 flex gap-2 flex-wrap">


<button

@click="action(`/admin/merchants/${merchant.id}/verify`)"

class="px-3 py-2 rounded-lg bg-emerald-500 text-white text-xs"

>

Verify

</button>




<button

@click="action(`/admin/merchants/${merchant.id}/reject`)"

class="px-3 py-2 rounded-lg bg-red-500 text-white text-xs"

>

Reject

</button>




<button

@click="action(`/admin/merchants/${merchant.id}/suspend`)"

class="px-3 py-2 rounded-lg bg-slate-700 text-white text-xs"

>

Suspend

</button>



</td>




</tr>



</tbody>



</table>


</div>







<div class="p-5 flex flex-wrap gap-2 border-t dark:border-slate-800">


<a

v-for="link in merchants.links"

:key="link.label"

:href="link.url"

v-html="link.label"

class="px-3 py-2 rounded-lg border dark:border-slate-700 text-sm"

:class="{

'bg-slate-900 text-white dark:bg-white dark:text-slate-900':link.active

}"

>


</a>


</div>






</div>





</div>



</DashboardLayout>



</template>
