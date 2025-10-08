<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-primary text-xl leading-tight py-2">
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
                        color="text-green-500"
                        icon="arrow-up"
                    />
                    <StatsCard
                        title="Total Expenses"
                        :value="stats.totalExpenses"
                        color="text-red-500"
                        icon="arrow-down"
                    />
                    <StatsCard
                        title="Balance"
                        :value="stats.balance"
                        :color="
                            stats.balance >= 0
                                ? 'text-green-500'
                                : 'text-red-500'
                        "
                        icon="banknotes"
                    />
                    <StatsCard
                        title="Transactions"
                        :value="stats.transactionCount"
                        color="text-blue-500"
                        icon="list-bullet"
                        :formatCurreny="false"
                    />
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Spending by Category Chart -->
                    <div
                        class="bg-card text-card-foreground overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6">
                            <h3
                                class="text-lg font-medium text-card-foreground mb-4"
                            >
                                Spending by Category
                            </h3>
                            <SpendingChart :data="spendingByCategory" />
                        </div>
                    </div>

                    <!-- Recent Transactions -->
                    <div
                        class="bg-card text-card-foreground overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3
                                    class="text-lg font-medium text-card-foreground"
                                >
                                    Recent Transactions
                                </h3>
                                <Link
                                    :href="route('transactions.index')"
                                    class="text-sm hover:text-primary/100"
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
                    class="bg-card text-card-foreground overflow-hidden shadow-sm sm:rounded-lg"
                    v-if="budgets.length > 0"
                >
                    <div class="p-6">
                        <h3
                            class="text-lg font-medium text-card-foreground mb-4"
                        >
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
