<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Transaction
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-card overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submitForm" class="space-y-6">
                            <!-- Type Display (Read-only) -->
                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    Transaction Type
                                </label>
                                <div
                                    :class="[
                                        'p-4 border-2 rounded-lg',
                                        transaction.type === 'income'
                                            ? 'border-green-500 bg-success-content'
                                            : 'border-red-500 bg-error-content',
                                    ]"
                                >
                                    <div class="text-2xl mb-2">
                                        {{
                                            transaction.type === "income"
                                                ? "💰"
                                                : "💸"
                                        }}
                                    </div>
                                    <div class="font-medium capitalize">
                                        {{ transaction.type }}
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    Transaction type cannot be changed
                                </p>
                            </div>

                            <!-- Category -->
                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    Category *
                                </label>
                                <select
                                    v-model="form.category_id"
                                    class="w-full bg-accent rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required
                                >
                                    <option value="">Select a category</option>
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
                                <label class="block text-sm font-medium mb-2">
                                    Amount *
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
                                        class="w-full bg-accent pl-7 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required
                                    />
                                </div>
                                <div
                                    v-if="form.errors.amount"
                                    class="text-red-600 text-sm mt-1"
                                >
                                    {{ form.errors.amount }}
                                </div>
                            </div>

                            <!-- Date -->
                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    Date *
                                </label>
                                <input
                                    v-model="form.transaction_date"
                                    type="date"
                                    class="w-full bg-accent rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required
                                />
                                <div
                                    v-if="form.errors.transaction_date"
                                    class="text-red-600 text-sm mt-1"
                                >
                                    {{ form.errors.transaction_date }}
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    Description
                                </label>
                                <textarea
                                    v-model="form.description"
                                    rows="3"
                                    placeholder="Add a note about this transaction..."
                                    class="w-full bg-accent rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                ></textarea>
                                <div
                                    v-if="form.errors.description"
                                    class="text-red-600 text-sm mt-1"
                                >
                                    {{ form.errors.description }}
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="flex justify-end space-x-3">
                                <Link
                                    :href="route('transactions.index')"
                                    class="px-4 py-2 bg-muted text-muted-700 rounded-md hover:bg-muted/30"
                                >
                                    Cancel
                                </Link>
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="px-4 py-2 bg-primary text-primary-foreground rounded-md hover:bg-primary/70 disabled:opacity-50"
                                >
                                    {{
                                        form.processing
                                            ? "Updating..."
                                            : "Update Transaction"
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
    transaction: Object,
    categories: Array,
});

const form = useForm({
    category_id: props.transaction.category_id,
    amount: props.transaction.amount,
    transaction_date: props.transaction.transaction_date,
    description: props.transaction.description || "",
});

const submitForm = () => {
    form.put(route("transactions.update", props.transaction.id));
};
</script>
