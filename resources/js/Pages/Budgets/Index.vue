<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-primary text-xl leading-tight">
                    Budgets
                </h2>
                <Link
                    :href="route('budgets.create')"
                    class="px-4 py-2 bg-primary rounded-md hover:bg-primary/70"
                >
                    Add Budget
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Flash Messages -->
                <div
                    v-if="$page.props.flash && $page.props.flash.success"
                    class="mb-4 p-4 bg-success-content border border-green-200 rounded-lg"
                >
                    {{ $page.props.flash.success }}
                </div>
                <div
                    v-if="$page.props.flash && $page.props.flash.error"
                    class="mb-4 p-4 bg-error-content border border-red-200 rounded-lg"
                >
                    {{ $page.props.flash.error }}
                </div>

                <!-- Month/Year Selector -->
                <div
                    class="bg-card overflow-hidden shadow-sm sm:rounded-lg mb-6"
                >
                    <div class="p-6">
                        <div class="flex items-center space-x-4">
                            <div>
                                <label class="block text-sm font-medium mb-2"
                                    >Month</label
                                >
                                <select
                                    v-model="selectedMonth"
                                    @change="updatePeriod"
                                    class="rounded-md bg-accent border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                    <option
                                        v-for="month in months"
                                        :key="month.value"
                                        :value="month.value"
                                    >
                                        {{ month.label }}
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2"
                                    >Year</label
                                >
                                <select
                                    v-model="selectedYear"
                                    @change="updatePeriod"
                                    class="rounded-md bg-accent border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                    <option
                                        v-for="year in years"
                                        :key="year"
                                        :value="year"
                                    >
                                        {{ year }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Budgets List -->
                <div class="bg-card overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div
                            v-if="budgets.length === 0"
                            class="text-center py-12"
                        >
                            <p class="text-muted-foreground mb-4">
                                No budgets set for this period
                            </p>
                            <Link
                                :href="route('budgets.create')"
                                class="text-primary hover:text-primary/70 font-medium"
                            >
                                Create your first budget
                            </Link>
                        </div>

                        <div v-else class="space-y-6">
                            <div
                                v-for="budget in budgets"
                                :key="budget.id"
                                class="border rounded-lg p-6 hover:shadow-md transition"
                            >
                                <div
                                    class="flex justify-between items-start mb-4"
                                >
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-12 h-12 rounded-full flex items-center justify-center"
                                            :style="{
                                                backgroundColor:
                                                    budget.category.color,
                                            }"
                                        >
                                            <span class="text-white text-xl"
                                                >💸</span
                                            >
                                        </div>
                                        <div>
                                            <h3 class="font-medium text-lg">
                                                {{ budget.category.name }}
                                            </h3>
                                            <p
                                                class="text-sm text-muted-foreground"
                                            >
                                                {{
                                                    formatCurrency(budget.spent)
                                                }}
                                                of
                                                {{
                                                    formatCurrency(
                                                        budget.amount
                                                    )
                                                }}
                                                spent
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex space-x-2">
                                        <Link
                                            :href="
                                                route('budgets.edit', budget.id)
                                            "
                                            class="hover:text-info"
                                        >
                                            <svg
                                                class="w-5 h-5"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                />
                                            </svg>
                                        </Link>
                                        <button
                                            @click="deleteBudget(budget.id)"
                                            class="hover:text-primary"
                                        >
                                            <svg
                                                class="w-5 h-5"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Progress Bar -->
                                <div class="space-y-2">
                                    <div
                                        class="w-full bg-accent rounded-full h-3"
                                    >
                                        <div
                                            class="h-3 rounded-full transition-all"
                                            :class="
                                                getProgressColor(
                                                    budget.percentage
                                                )
                                            "
                                            :style="{
                                                width:
                                                    Math.min(
                                                        budget.percentage,
                                                        100
                                                    ) + '%',
                                            }"
                                        ></div>
                                    </div>

                                    <div class="flex justify-between text-sm">
                                        <span
                                            :class="
                                                budget.remaining >= 0
                                                    ? 'text-green-600'
                                                    : 'text-red-600'
                                            "
                                            class="font-medium"
                                        >
                                            {{
                                                budget.remaining >= 0
                                                    ? formatCurrency(
                                                          budget.remaining
                                                      ) + " remaining"
                                                    : formatCurrency(
                                                          Math.abs(
                                                              budget.remaining
                                                          )
                                                      ) + " over budget"
                                            }}
                                        </span>
                                        <span class="text-muted-foreground"
                                            >{{
                                                Math.round(budget.percentage)
                                            }}%</span
                                        >
                                    </div>
                                </div>

                                <!-- Warning if over budget -->
                                <!-- Warning if budget is exactly used -->
                                <div
                                    v-if="
                                        budget.percentage === 100 &&
                                        budget.remaining === 0
                                    "
                                    class="mt-3 p-3 bg-info-content border border-blue-200 rounded-md"
                                >
                                    <p class="text-sm">
                                        <span class="font-medium"
                                            >✅ Budget exactly used!</span
                                        >
                                        You've used your entire budget for this
                                        category.
                                    </p>
                                </div>

                                <!-- Warning if over budget -->
                                <div
                                    v-else-if="budget.percentage > 100"
                                    class="mt-3 p-3 bg-error-content border border-red-200 rounded-md"
                                >
                                    <p class="text-sm">
                                        <span class="font-medium"
                                            >⚠️ Budget exceeded!</span
                                        >
                                        You've gone
                                        {{
                                            formatCurrency(
                                                Math.abs(budget.remaining)
                                            )
                                        }}
                                        over your budget for this category.
                                    </p>
                                </div>

                                <!-- Warning if near budget -->
                                <div
                                    v-else-if="budget.percentage >= 90"
                                    class="mt-3 p-3 bg-warning-content border border-yellow-200 rounded-md"
                                >
                                    <p class="text-sm">
                                        <span class="font-medium"
                                            >⚡ Almost there!</span
                                        >
                                        You have
                                        {{ formatCurrency(budget.remaining) }}
                                        left for this category.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, router } from "@inertiajs/vue3";

const props = defineProps({
    budgets: Array,
    categories: Array,
    currentMonth: Number,
    currentYear: Number,
});

const selectedMonth = ref(props.currentMonth);
const selectedYear = ref(props.currentYear);

const months = [
    { value: 1, label: "January" },
    { value: 2, label: "February" },
    { value: 3, label: "March" },
    { value: 4, label: "April" },
    { value: 5, label: "May" },
    { value: 6, label: "June" },
    { value: 7, label: "July" },
    { value: 8, label: "August" },
    { value: 9, label: "September" },
    { value: 10, label: "October" },
    { value: 11, label: "November" },
    { value: 12, label: "December" },
];

const currentYear = new Date().getFullYear();
const years = Array.from({ length: 5 }, (_, i) => currentYear - 2 + i);

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

const updatePeriod = () => {
    router.get(
        route("budgets.index"),
        {
            month: selectedMonth.value,
            year: selectedYear.value,
        },
        {
            preserveState: true,
        }
    );
};

const deleteBudget = (id) => {
    if (confirm("Are you sure you want to delete this budget?")) {
        router.delete(route("budgets.destroy", id));
    }
};
</script>
