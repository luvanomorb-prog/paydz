<template>
  <div class="fixed inset-0 overflow-hidden -z-10">
    <div class="absolute w-96 h-96 bg-blue-500/20 rounded-full blur-3xl animate-float top-10 left-10"></div>

    <div class="absolute w-[500px] h-[500px] bg-cyan-500/20 rounded-full blur-3xl animate-float2 bottom-10 right-10"></div>

    <div class="absolute w-72 h-72 bg-indigo-500/20 rounded-full blur-3xl animate-float3 top-1/2 left-1/2 -translate-x-1/2"></div>
  </div>
</template>

<script setup>
</script>

<style scoped>
@keyframes float {
    0%{transform:translateY(0);}
    50%{transform:translateY(-40px);}
    100%{transform:translateY(0);}
}

@keyframes float2{
    0%{transform:translateX(0);}
    50%{transform:translateX(50px);}
    100%{transform:translateX(0);}
}

@keyframes float3{
    0%{transform:translate(0,0);}
    50%{transform:translate(-30px,30px);}
    100%{transform:translate(0,0);}
}

.animate-float{
    animation:float 8s ease-in-out infinite;
}

.animate-float2{
    animation:float2 10s ease-in-out infinite;
}

.animate-float3{
    animation:float3 12s ease-in-out infinite;
}
</style>
