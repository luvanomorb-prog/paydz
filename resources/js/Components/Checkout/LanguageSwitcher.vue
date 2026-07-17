<template>

<select
v-model="lang"
class="rounded-xl bg-slate-900 border border-slate-700 px-4 py-2">

<option value="en">

English

</option>

<option value="fr">

Français

</option>

<option value="ar">

العربية

</option>

</select>

</template>

<script setup>

import {ref} from 'vue'

const lang=ref('en')

</script>
