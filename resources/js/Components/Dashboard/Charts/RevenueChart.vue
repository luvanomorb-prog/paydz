<script setup>

import { computed } from 'vue'
import {
    Chart as ChartJS,
    LineElement,
    PointElement,
    CategoryScale,
    LinearScale,
    Tooltip,
    Legend
} from 'chart.js'

import { Line } from 'vue-chartjs'


ChartJS.register(
    LineElement,
    PointElement,
    CategoryScale,
    LinearScale,
    Tooltip,
    Legend
)


const props = defineProps({

    revenue:{
        type:Object,
        default:()=>({
            labels:[],
            values:[]
        })
    }

})


const chartData = computed(()=>({

    labels: props.revenue.labels,

    datasets:[

        {
            label:'Revenue',

            data:props.revenue.values,

            tension:0.4,

            borderWidth:3,

            pointRadius:4

        }

    ]

}))


const chartOptions={

    responsive:true,

    maintainAspectRatio:false,

    plugins:{

        legend:{
            display:false
        }

    }

}


</script>


<template>

<div class="bg-white dark:bg-slate-900 rounded-2xl shadow p-6 border dark:border-slate-800">


<h2 class="font-bold text-lg dark:text-white mb-5">
Revenue Overview
</h2>


<div class="h-48">

<Line
    :data="chartData"
    :options="chartOptions"
/>

</div>


</div>

</template>
