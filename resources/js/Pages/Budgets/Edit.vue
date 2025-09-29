<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Budget
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submitForm" class="space-y-6">
                            <!-- Category Display (Read-only) -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Category
                                </label>
                                <div
                                    class="flex items-center space-x-3 p-4 bg-gray-50 rounded-lg"
                                >
                                    <div
                                        class="w-10 h-10 rounded-full flex items-center justify-center"
                                        :style="{
                                            backgroundColor:
                                                budget.category.color,
                                        }"
                                    >
                                        <span class="text-white text-lg"
                                            >💸</span
                                        >
                                    </div>
                                    <span class="font-medium text-gray-900">{{
                                        budget.category.name
                                    }}</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    Category cannot be changed
                                </p>
                            </div>

                            <!-- Period Display (Read-only) -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Budget Period
                                </label>
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <span class="font-medium text-gray-900"
                                        >{{ getMonthName(budget.month) }}
                                        {{ budget.year }}</span
                                    >
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    Period cannot be changed
                                </p>
                            </div>

                            <!-- Amount -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Budget Amount *
                                </label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
                                    >
                                        <span class="text-gray-500">$</span>
                                    </div>
                                    <input
                                        v-model="form.amount"
                                        type="number"
                                        step="0.01"
                                        min="0.01"
                                        placeholder="0.00"
                                        class="w-full pl-7 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required
                                    />
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    Update the maximum amount for this category
                                </p>
                                <div
                                    v-if="form.errors.amount"
                                    class="text-red-600 text-sm mt-1"
                                >
                                    {{ form.errors.amount }}
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="flex justify-end space-x-3">
                                <Link
                                    :href="route('budgets.index')"
                                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300"
                                >
                                    Cancel
                                </Link>
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 disabled:opacity-50"
                                >
                                    {{
                                        form.processing
                                            ? "Updating..."
                                            : "Update Budget"
                                    }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
    budget: Object,
    categories: Array,
});

const form = useForm({
    amount: props.budget.amount,
});

const months = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
];

const getMonthName = (monthNumber) => {
    return months[monthNumber - 1];
};

const submitForm = () => {
    form.put(route("budgets.update", props.budget.id));
};
</script>
