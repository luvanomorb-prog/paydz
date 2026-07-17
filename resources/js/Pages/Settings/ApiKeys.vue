<script setup>

import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import { router } from '@inertiajs/vue3'


defineProps({

apiKey:Object

})


function regenerate(){

router.post(
'/settings/api-keys/regenerate'
)

}


</script>



<template>

<DashboardLayout>


<div class="p-6">


<h1 class="text-2xl font-bold">
API Keys
</h1>



<div class="mt-6">


<label>
Public Key
</label>


<input
class="border p-2 w-full"
:value="apiKey?.public_key"
readonly
/>



<label class="mt-4 block">
Secret Key
</label>


<input
class="border p-2 w-full"
:value="apiKey?.secret_key"
readonly
/>



<button
@click="regenerate"
class="mt-5 bg-black text-white px-5 py-2 rounded"
>

Regenerate Secret

</button>


</div>


</div>


</DashboardLayout>


</template>

