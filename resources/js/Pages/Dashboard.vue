<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <StatsCard
                        title="Total Income"
                        :value="stats.totalIncome"
                        color="green"
                        icon="arrow-up"
                    />
                    <StatsCard
                        title="Total Expenses"
                        :value="stats.totalExpenses"
                        color="red"
                        icon="arrow-down"
                    />
                    <StatsCard
                        title="Balance"
                        :value="stats.balance"
                        :color="stats.balance >= 0 ? 'green' : 'red'"
                        icon="banknotes"
                    />
                    <StatsCard
                        title="Transactions"
                        :value="stats.transactionCount"
                        color="blue"
                        icon="list-bullet"
                        :formatCurreny="false"
                    />
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Spending by Category Chart -->
                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Spending by Category
                            </h3>
                            <SpendingChart :data="spendingByCategory" />
                        </div>
                    </div>

                    <!-- Recent Transactions -->
                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900">
                                    Recent Transactions
                                </h3>
                                <Link
                                    :href="route('transactions.index')"
                                    class="text-sm text-indigo-600 hover:text-indigo-900"
                                >
                                    View all
                                </Link>
                            </div>
                            <TransactionList
                                :transactions="recentTransactions"
                            />
                        </div>
                    </div>
                </div>

                <!-- Budget Progress -->
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    v-if="budgets.length > 0"
                >
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            Budget Progress
                        </h3>
                        <BudgetProgress :budgets="budgets" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link } from "@inertiajs/vue3";
import StatsCard from "@/Components/StatsCard.vue";
import SpendingChart from "@/Components/SpendingChart.vue";
import TransactionList from "@/Components/TransactionList.vue";
import BudgetProgress from "@/Components/BudgetProgress.vue";

defineProps({
    stats: Object,
    recentTransactions: Array,
    spendingByCategory: Array,
    budgets: Array,
});
</script>
