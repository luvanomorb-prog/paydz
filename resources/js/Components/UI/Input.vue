<script setup>

defineProps({

modelValue:String,

placeholder:String,

type:{

default:"text"

}

})

defineEmits(["update:modelValue"])

</script>

<template>

<input

:placeholder="placeholder"

:type="type"

:value="modelValue"

@input="$emit('update:modelValue',$event.target.value)"

class="

w-full

rounded-xl

border

border-white/10

bg-white/5

backdrop-blur

px-4

py-3

text-white

placeholder:text-gray-400

outline-none

focus:ring-2

focus:ring-cyan-500"/>

</template>

