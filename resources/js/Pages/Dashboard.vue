<script setup>

import { Head } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'


import PaymentsCard from '@/Components/Dashboard/Cards/PaymentsCard.vue'
import TransactionsCard from '@/Components/Dashboard/Cards/TransactionsCard.vue'
import SuccessRateCard from '@/Components/Dashboard/Cards/SuccessRateCard.vue'
import RevenueCard from '@/Components/Dashboard/Cards/RevenueCard.vue'

import BalanceCard from '@/Components/Dashboard/BalanceCard.vue'
import RevenueChart from '@/Components/Dashboard/Charts/RevenueChart.vue'


import RecentPaymentsTable from '@/Components/Dashboard/Tables/RecentPaymentsTable.vue'
import RecentTransactionsTable from '@/Components/Dashboard/Tables/RecentTransactionsTable.vue'


import ActivityFeed from '@/Components/Dashboard/Widgets/ActivityFeed.vue'
import Notifications from '@/Components/Dashboard/Widgets/Notifications.vue'
import QuickActions from '@/Components/Dashboard/Widgets/QuickActions.vue'



const props = defineProps({

    merchant:Object,

    stats:Object,

    payments:Object,

    transactions:Object,

    revenue_chart:Object,

})



const successRate = props.stats.payments

    ? Math.round(
        (props.stats.paid_payments / props.stats.payments) * 100
      )

    : 0



</script>



<template>

<Head title="Dashboard"/>


<DashboardLayout>


<div class="space-y-8">



<div>

<h1 class="text-3xl font-bold text-slate-900 dark:text-white">
Welcome {{ merchant.business_name }}
</h1>


<p class="text-slate-500 mt-2">
Your PayDZ merchant overview
</p>


</div>




<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">


<PaymentsCard
:total="stats.payments"
:paid="stats.paid_payments"
/>


<TransactionsCard
:total="stats.transactions"
:pending="stats.pending_payments"
:failed="stats.failed_payments"
/>


<SuccessRateCard
:rate="successRate"
/>


<RevenueCard
:revenue="stats.revenue"
/>


</div>





<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">


<div class="xl:col-span-2">

<RevenueChart
:revenue="revenue_chart"
/>

</div>



<div>

<BalanceCard
:amount="stats.revenue"
currency="DZD"
/>


</div>



</div>





<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">


<div class="xl:col-span-2">


<RecentPaymentsTable
:payments="payments"
/>


</div>



<div>


<Notifications
:notifications="[]"
/>


</div>



</div>






<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">


<RecentTransactionsTable
:transactions="transactions"
/>


<ActivityFeed/>


</div>





<QuickActions/>


</div>


</DashboardLayout>


</template>
