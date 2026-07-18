<script setup>

import { Head, useForm } from '@inertiajs/vue3'


const props = defineProps({

    merchant:Object,

    documents:Array

})



const form = useForm({

    type:'identity_card',

    document:null

})



function submit(){

    form.post(
        route('merchant.kyc.store'),
        {

            forceFormData:true,

            onSuccess(){

                form.reset('document')

            }

        }
    )

}



function statusClass(status){

    return {

        pending:
        'bg-yellow-100 text-yellow-700',

        approved:
        'bg-green-100 text-green-700',

        rejected:
        'bg-red-100 text-red-700'

    }[status]

}



</script>





<template>

<Head title="KYC Verification"/>


<div class="min-h-screen bg-slate-50 dark:bg-slate-950 p-8">


<div class="max-w-5xl mx-auto space-y-8">





<div class="bg-white dark:bg-slate-900 rounded-3xl shadow p-8">


<h1 class="text-3xl font-bold text-slate-900 dark:text-white">

Verification Center

</h1>


<p class="text-slate-500 mt-2">

Complete your KYC verification to activate payments.

</p>



<div class="mt-6 flex items-center gap-3">


<span
class="px-4 py-2 rounded-full text-sm font-bold"
:class="merchant.kyc_verified
?
'bg-green-100 text-green-700'
:
'bg-yellow-100 text-yellow-700'"
>

{{ merchant.kyc_verified ? 'Verified' : 'Pending Review' }}

</span>


</div>


</div>







<div class="bg-white dark:bg-slate-900 rounded-3xl shadow p-8">


<h2 class="text-xl font-bold dark:text-white mb-6">

Upload Document

</h2>



<form
@submit.prevent="submit"
class="space-y-5"
>



<select
v-model="form.type"
class="w-full rounded-xl border p-3 dark:bg-slate-800"
>


<option value="identity_card">
Identity Card
</option>


<option value="passport">
Passport
</option>


<option value="business_registration">
Business Registration
</option>


<option value="tax_document">
Tax Document
</option>


<option value="bank_document">
Bank Document
</option>


<option value="address_proof">
Address Proof
</option>


</select>





<input
type="file"
@change="form.document=$event.target.files[0]"
class="w-full border rounded-xl p-3"
/>






<button
class="px-6 py-3 rounded-xl bg-indigo-600 text-white font-bold"
:disabled="form.processing"
>

Upload Document

</button>



</form>


</div>








<div class="bg-white dark:bg-slate-900 rounded-3xl shadow p-8">


<h2 class="text-xl font-bold dark:text-white mb-6">

Documents History

</h2>



<div
v-if="documents.length"
class="space-y-4"
>



<div
v-for="doc in documents"
:key="doc.id"
class="flex justify-between items-center border rounded-xl p-4"
>


<div>


<p class="font-semibold dark:text-white">

{{ doc.type }}

</p>


<p class="text-sm text-slate-500">

{{ doc.created_at }}

</p>


</div>





<span
class="px-3 py-1 rounded-full text-xs font-bold"
:class="statusClass(doc.status)"
>

{{ doc.status }}

</span>


</div>


</div>



<div v-else class="text-slate-400">

No documents uploaded.

</div>



</div>






</div>


</div>


</template>
