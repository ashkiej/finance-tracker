<template>
    <div class="space-y-3">
        <div
            v-if="transactions.length === 0"
            class="text-center py-8 text-muted-foreground"
        >
            No transactions found
        </div>

        <div
            v-for="transaction in transactions"
            :key="transaction.id"
            class="flex items-center justify-between p-4 bg-accent rounded-lg hover:bg-accent/50 transition"
        >
            <div class="flex items-center space-x-4">
                <div
                    class="w-10 h-10 rounded-full flex items-center justify-center"
                    :style="{
                        backgroundColor: transaction.category.color + '20',
                    }"
                >
                    <span class="text-lg">💰</span>
                </div>
                <div>
                    <p class="font-medium text-foreground">
                        {{ transaction.category.name }}
                    </p>
                    <p class="text-sm text-muted-foreground">
                        {{ transaction.description || "No description" }}
                    </p>
                    <p class="text-xs text-muted-foreground/50">
                        {{ formatDate(transaction.transaction_date) }}
                    </p>
                </div>
            </div>

            <div class="text-right">
                <p
                    class="font-semibold"
                    :class="
                        transaction.type === 'income'
                            ? 'text-success'
                            : 'text-primary'
                    "
                >
                    {{ transaction.type === "income" ? "+" : "-"
                    }}{{ formatCurrency(transaction.amount) }}
                </p>
                <div class="flex space-x-2 mt-1" v-if="showActions">
                    <Link
                        :href="route('transactions.edit', transaction.id)"
                        class="text-xs hover:text-info"
                    >
                        Edit
                    </Link>
                    <button
                        @click="deleteTransaction(transaction.id)"
                        class="text-xs hover:text-primary/90"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";

defineProps({
    transactions: Array,
    showActions: {
        type: Boolean,
        default: false,
    },
});

const formatCurrency = (amount) => {
    return new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
    }).format(amount);
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString("en-US", {
        month: "short",
        day: "numeric",
        year: "numeric",
    });
};

const deleteTransaction = (id) => {
    if (confirm("Are you sure you want to delete this transaction?")) {
        router.delete(route("transactions.destroy", id));
    }
};
</script>
