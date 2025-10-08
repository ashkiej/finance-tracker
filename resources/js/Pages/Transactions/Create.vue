<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">
                Add New Transaction
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-card overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submitForm" class="space-y-6">
                            <!-- Type Selection -->
                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    Transaction Type *
                                </label>
                                <div class="grid grid-cols-2 gap-4">
                                    <button
                                        type="button"
                                        @click="form.type = 'income'"
                                        :class="[
                                            'p-4 border-2 rounded-lg transition',
                                            form.type === 'income'
                                                ? 'border-green-500 bg-success-content'
                                                : 'border-gray-300 hover:border-gray-400',
                                        ]"
                                    >
                                        <div class="text-2xl mb-2">💰</div>
                                        <div
                                            class="font-medium text-accent-foreground"
                                        >
                                            Income
                                        </div>
                                    </button>
                                    <button
                                        type="button"
                                        @click="form.type = 'expense'"
                                        :class="[
                                            'p-4 border-2 rounded-lg transition',
                                            form.type === 'expense'
                                                ? 'border-red-500 bg-error-content'
                                                : 'border-gray-300 hover:border-gray-400',
                                        ]"
                                    >
                                        <div class="text-2xl mb-2">💸</div>
                                        <div
                                            class="font-medium text-accent-foreground"
                                        >
                                            Expense
                                        </div>
                                    </button>
                                </div>
                                <div
                                    v-if="form.errors.type"
                                    class="text-red-600 text-sm mt-1"
                                >
                                    {{ form.errors.type }}
                                </div>
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
                                        v-for="category in filteredCategories"
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
                                        <span class="text-accent-foreground"
                                            >$</span
                                        >
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
                                    class="px-4 py-2 bg-primary rounded-md hover:bg-primary/70 disabled:opacity-50"
                                >
                                    {{
                                        form.processing
                                            ? "Saving..."
                                            : "Save Transaction"
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
import { computed } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
    categories: Array,
});

const form = useForm({
    type: "expense",
    category_id: "",
    amount: "",
    transaction_date: new Date().toISOString().split("T")[0],
    description: "",
});

const filteredCategories = computed(() => {
    return props.categories.filter((cat) => cat.type === form.type);
});

const submitForm = () => {
    form.post(route("transactions.store"));
};
</script>
