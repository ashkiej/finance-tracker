<template>
    <div class="space-y-4">
        <div v-if="budgets.length === 0" class="text-center py-8">
            No budgets set for this month
        </div>

        <div v-for="budget in budgets" :key="budget.id" class="space-y-2">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-3 h-3 rounded-full"
                        :style="{ backgroundColor: budget.category.color }"
                    ></div>
                    <span class="font-medium">{{ budget.category.name }}</span>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium">
                        {{ formatCurrency(budget.spent) }} /
                        {{ formatCurrency(budget.amount) }}
                    </p>
                    <p class="text-xs text-muted-foreground/50">
                        {{ formatCurrency(budget.remaining) }} remaining
                    </p>
                </div>
            </div>

            <div class="w-full bg-gray-200 rounded-full h-2">
                <div
                    class="h-2 rounded-full transition-all"
                    :class="getProgressColor(budget.percentage)"
                    :style="{ width: Math.min(budget.percentage, 100) + '%' }"
                ></div>
            </div>

            <p class="text-xs text-muted-foreground/50">
                {{ Math.round(budget.percentage) }}% used
            </p>
        </div>
    </div>
</template>

<script setup>
defineProps({
    budgets: Array,
});

const formatCurrency = (amount) => {
    return new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
    }).format(amount);
};

const getProgressColor = (percentage) => {
    if (percentage < 50) return "bg-green-500";
    if (percentage < 75) return "bg-yellow-500";
    if (percentage < 90) return "bg-orange-500";
    return "bg-red-500";
};
</script>
