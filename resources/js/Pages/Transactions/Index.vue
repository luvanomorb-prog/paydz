<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    transactions: Object
});
</script>


<template>
    <div class="p-6">

        <h1 class="text-2xl font-bold mb-6">
            Transactions
        </h1>


        <div class="bg-white rounded-xl shadow overflow-hidden">

            <table class="w-full">

                <thead>
                    <tr class="border-b">
                        <th class="p-4 text-left">ID</th>
                        <th class="p-4 text-left">Amount</th>
                        <th class="p-4 text-left">Status</th>
                        <th class="p-4 text-left">Date</th>
                    </tr>
                </thead>


                <tbody>

                    <tr 
                    v-for="transaction in transactions.data"
                    :key="transaction.id"
                    class="border-b hover:bg-gray-50">

                        <td class="p-4">
                            <Link 
                            :href="`/transactions/${transaction.id}`"
                            class="text-blue-600">
                                #{{transaction.id}}
                            </Link>
                        </td>


                        <td class="p-4">
                            {{transaction.amount}}
                        </td>


                        <td class="p-4">
                            {{transaction.status}}
                        </td>


                        <td class="p-4">
                            {{transaction.created_at}}
                        </td>


                    </tr>

                </tbody>

            </table>

        </div>

    </div>
</template>
