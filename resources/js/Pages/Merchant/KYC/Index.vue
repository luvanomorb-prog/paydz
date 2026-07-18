<script setup>

import { Head, router } from '@inertiajs/vue3'

import { ref } from 'vue'



const props = defineProps({

    documents:Array,

    merchant:Object

})



const type = ref('')

const file = ref(null)



function upload()
{

    const form = new FormData()


    form.append(
        'type',
        type.value
    )


    form.append(
        'document',
        file.value
    )



    router.post(
        route('merchant.kyc.store'),
        form,
        {

            forceFormData:true

        }

    )

}



</script>





<template>


<Head title="KYC Verification"/>



<div class="min-h-screen bg-slate-50 dark:bg-slate-950 p-8">


<div class="max-w-5xl mx-auto space-y-8">





<h1 class="text-3xl font-black dark:text-white">

Merchant Verification

</h1>





<div class="bg-white dark:bg-slate-900 rounded-3xl shadow p-8">



<select

v-model="type"

class="w-full rounded-xl border p-3"

>


<option value="">
Select Document Type
</option>


<option value="business_license">
Business License
</option>


<option value="identity">
Identity Card
</option>


<option value="bank_document">
Bank Document
</option>


<option value="address">
Proof Of Address
</option>


</select>







<input

type="file"

class="mt-5"

@change="e=>file=e.target.files[0]"

/>








<button

@click="upload"

class="mt-6 bg-blue-600 text-white px-8 py-3 rounded-xl font-bold"

>

Upload Document

</button>



</div>








<div class="bg-white dark:bg-slate-900 rounded-3xl shadow p-8">


<h2 class="font-bold text-xl dark:text-white mb-5">

Uploaded Documents

</h2>




<div

v-for="doc in documents"

:key="doc.id"

class="border-b py-4 dark:border-slate-700"

>


<div class="flex justify-between">


<span class="dark:text-white font-semibold">

{{doc.type}}

</span>



<span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700">

{{doc.status}}

</span>


</div>



</div>


</div>





</div>


</div>


</template>
