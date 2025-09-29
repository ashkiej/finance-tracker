<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Set New Budget
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submitForm" class="space-y-6">
                            <!-- Category -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Category *
                                </label>
                                <select
                                    v-model="form.category_id"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required
                                >
                                    <option value="">
                                        Select an expense category
                                    </option>
                                    <option
                                        v-for="category in categories"
                                        :key="category.id"
                                        :value="category.id"
                                    >
                                        {{ category.name }}
                                    </option>
                                </select>
                                <div
                                    v-if="form.errors.category_id"
                                    class="text-red-600 text-sm mt-1"
                                >
                                    {{ form.errors.category_id }}
                                </div>
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
                                    Set the maximum amount you want to spend in
                                    this category
                                </p>
                                <div
                                    v-if="form.errors.amount"
                                    class="text-red-600 text-sm mt-1"
                                >
                                    {{ form.errors.amount }}
                                </div>
                            </div>

                            <!-- Month -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Month *
                                </label>
                                <select
                                    v-model="form.month"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required
                                >
                                    <option
                                        v-for="month in months"
                                        :key="month.value"
                                        :value="month.value"
                                    >
                                        {{ month.label }}
                                    </option>
                                </select>
                                <div
                                    v-if="form.errors.month"
                                    class="text-red-600 text-sm mt-1"
                                >
                                    {{ form.errors.month }}
                                </div>
                            </div>

                            <!-- Year -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Year *
                                </label>
                                <select
                                    v-model="form.year"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required
                                >
                                    <option
                                        v-for="year in years"
                                        :key="year"
                                        :value="year"
                                    >
                                        {{ year }}
                                    </option>
                                </select>
                                <div
                                    v-if="form.errors.year"
                                    class="text-red-600 text-sm mt-1"
                                >
                                    {{ form.errors.year }}
                                </div>
                            </div>

                            <!-- Info Box -->
                            <div
                                class="bg-blue-50 border border-blue-200 rounded-lg p-4"
                            >
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg
                                            class="h-5 w-5 text-blue-400"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3
                                            class="text-sm font-medium text-blue-800"
                                        >
                                            Budget Tips
                                        </h3>
                                        <div class="mt-2 text-sm text-blue-700">
                                            <ul
                                                class="list-disc list-inside space-y-1"
                                            >
                                                <li>
                                                    Budgets help you track
                                                    spending limits for each
                                                    category
                                                </li>
                                                <li>
                                                    You'll get alerts when
                                                    you're close to your budget
                                                    limit
                                                </li>
                                                <li>
                                                    Review and adjust budgets
                                                    monthly based on your
                                                    spending patterns
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
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
                                            ? "Saving..."
                                            : "Save Budget"
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
    categories: Array,
});

const currentDate = new Date();
const currentYear = currentDate.getFullYear();

const form = useForm({
    category_id: "",
    amount: "",
    month: currentDate.getMonth() + 1,
    year: currentYear,
});

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

const years = Array.from({ length: 5 }, (_, i) => currentYear - 2 + i);

const submitForm = () => {
    form.post(route("budgets.store"));
};
</script>
