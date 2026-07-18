<script setup>

import { Head, router } from '@inertiajs/vue3'
import { ref } from 'vue'


const props = defineProps({

    documents:Object

})



const rejectId = ref(null)

const reason = ref('')





function approve(id)
{

    router.post(
        route('admin.kyc.approve',id)
    )

}





function openReject(id)
{

    rejectId.value = id

}






function submitReject()
{

    router.post(

        route(
            'admin.kyc.reject',
            rejectId.value
        ),

        {
            reason:reason.value
        },

        {

            onSuccess(){

                rejectId.value=null

                reason.value=''

            }

        }

    )

}







function statusClass(status)
{

    const classes = {

        pending:
        'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',


        approved:
        'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',


        rejected:
        'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'

    }


    return classes[status] ?? ''

}





function viewDocument(id)
{

    window.open(
        route(
            'admin.kyc.view',
            id
        ),
        '_blank'
    )

}



</script>





<template>


<Head title="KYC Management"/>



<div class="min-h-screen bg-slate-50 dark:bg-slate-950 p-8">


<div class="max-w-7xl mx-auto space-y-8">





<div>

<h1 class="text-3xl font-black text-slate-900 dark:text-white">

KYC Verification Center

</h1>


<p class="text-slate-500 mt-2">

Review and approve merchant identity documents.

</p>


</div>







<div
class="bg-white dark:bg-slate-900 rounded-3xl shadow-xl overflow-hidden border dark:border-slate-800"
>




<table class="w-full">



<thead
class="bg-slate-100 dark:bg-slate-800"
>


<tr>


<th class="p-5 text-left">
Merchant
</th>


<th class="p-5 text-left">
Document
</th>


<th class="p-5 text-left">
Status
</th>


<th class="p-5 text-left">
Actions
</th>


</tr>


</thead>





<tbody>




<tr
v-for="doc in documents.data"
:key="doc.id"
class="border-t dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50"
>






<td class="p-5">


<div>


<p class="font-bold text-slate-900 dark:text-white">

{{ doc.merchant?.business_name }}

</p>


<p class="text-sm text-slate-500">

{{ doc.merchant?.business_email }}

</p>


</div>


</td>







<td class="p-5">


<p class="font-semibold dark:text-white">

{{ doc.type }}

</p>


<button

@click="viewDocument(doc.id)"

class="mt-2 text-sm text-blue-600 hover:underline"

>

View Document

</button>


</td>








<td class="p-5">


<span

class="px-4 py-2 rounded-full text-xs font-bold uppercase"

:class="statusClass(doc.status)"

>

{{ doc.status }}

</span>


</td>








<td class="p-5">


<div class="flex gap-3">



<button

@click="approve(doc.id)"

class="px-5 py-2 rounded-xl bg-green-600 text-white font-bold hover:bg-green-700"

>

Approve

</button>






<button

@click="openReject(doc.id)"

class="px-5 py-2 rounded-xl bg-red-600 text-white font-bold hover:bg-red-700"

>

Reject

</button>



</div>


</td>






</tr>




</tbody>


</table>




</div>








<div
class="flex justify-between items-center"
>


<div class="text-sm text-slate-500">

Total Documents:
{{ documents.total }}

</div>


</div>









<div

v-if="rejectId"

class="fixed inset-0 bg-black/60 flex items-center justify-center z-50"

>




<div

class="bg-white dark:bg-slate-900 rounded-3xl p-8 w-full max-w-md shadow-2xl"

>



<h2 class="text-xl font-black dark:text-white">

Reject KYC Document

</h2>




<p class="text-slate-500 mt-2">

Explain why this document was rejected.

</p>






<textarea

v-model="reason"

rows="5"

class="w-full mt-5 rounded-xl border p-4 dark:bg-slate-800 dark:text-white"

placeholder="Rejection reason..."

></textarea>






<div class="flex gap-3 mt-6">



<button

@click="submitReject"

class="flex-1 bg-red-600 text-white py-3 rounded-xl font-bold"

>

Confirm Reject

</button>





<button

@click="rejectId=null"

class="flex-1 border py-3 rounded-xl dark:text-white"

>

Cancel

</button>



</div>




</div>


</div>








</div>


</div>


</template>
