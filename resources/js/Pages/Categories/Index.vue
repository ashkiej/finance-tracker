<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-primary text-xl leading-tight">
                    Categories
                </h2>
                <Link
                    :href="route('categories.create')"
                    class="px-4 py-2 bg-primary rounded-md hover:bg-primary/70"
                >
                    Add Category
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Flash Messages -->
                <div
                    v-if="$page.props.flash && $page.props.flash.success"
                    class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg"
                >
                    {{ $page.props.flash.success }}
                </div>
                <div
                    v-if="$page.props.flash && $page.props.flash.error"
                    class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg"
                >
                    {{ $page.props.flash.error }}
                </div>

                <!-- Income Categories -->
                <div
                    class="bg-card overflow-hidden shadow-sm sm:rounded-lg mb-6"
                >
                    <div class="p-6">
                        <h3 class="text-lg font-medium mb-4">
                            Income Categories
                        </h3>
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"
                        >
                            <div
                                v-for="category in incomeCategories"
                                :key="category.id"
                                class="border rounded-lg p-4 hover:shadow-md transition"
                            >
                                <div class="flex justify-between items-start">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-10 h-10 rounded-full flex items-center justify-center"
                                            :style="{
                                                backgroundColor: category.color,
                                            }"
                                        >
                                            <span class="text-white text-lg"
                                                >💰</span
                                            >
                                        </div>
                                        <div>
                                            <h4 class="font-medium">
                                                {{ category.name }}
                                            </h4>
                                            <p
                                                class="text-sm text-muted-foreground"
                                            >
                                                {{
                                                    category.transactions_count
                                                }}
                                                transactions
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <Link
                                            :href="
                                                route(
                                                    'categories.edit',
                                                    category.id
                                                )
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
                                            @click="deleteCategory(category.id)"
                                            class="hover:text-primary"
                                            :disabled="
                                                category.transactions_count > 0
                                            "
                                            :class="{
                                                'opacity-50 cursor-not-allowed':
                                                    category.transactions_count >
                                                    0,
                                            }"
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
                            </div>
                        </div>
                        <div
                            v-if="incomeCategories.length === 0"
                            class="text-center py-8 text-gray-500"
                        >
                            No income categories yet
                        </div>
                    </div>
                </div>

                <!-- Expense Categories -->
                <div class="bg-card overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium mb-4">
                            Expense Categories
                        </h3>
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"
                        >
                            <div
                                v-for="category in expenseCategories"
                                :key="category.id"
                                class="border rounded-lg p-4 hover:shadow-md transition"
                            >
                                <div class="flex justify-between items-start">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-10 h-10 rounded-full flex items-center justify-center"
                                            :style="{
                                                backgroundColor: category.color,
                                            }"
                                        >
                                            <span class="text-white text-lg"
                                                >💸</span
                                            >
                                        </div>
                                        <div>
                                            <h4 class="font-medium">
                                                {{ category.name }}
                                            </h4>
                                            <p
                                                class="text-sm text-muted-foreground"
                                            >
                                                {{
                                                    category.transactions_count
                                                }}
                                                transactions
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <Link
                                            :href="
                                                route(
                                                    'categories.edit',
                                                    category.id
                                                )
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
                                            @click="deleteCategory(category.id)"
                                            class="hover:text-primary"
                                            :disabled="
                                                category.transactions_count > 0
                                            "
                                            :class="{
                                                'opacity-50 cursor-not-allowed':
                                                    category.transactions_count >
                                                    0,
                                            }"
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
                            </div>
                        </div>
                        <div
                            v-if="expenseCategories.length === 0"
                            class="text-center py-8 text-gray-500"
                        >
                            No expense categories yet
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { computed } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, router } from "@inertiajs/vue3";

const props = defineProps({
    categories: Array,
});

const incomeCategories = computed(() => {
    return props.categories.filter((cat) => cat.type === "income");
});

const expenseCategories = computed(() => {
    return props.categories.filter((cat) => cat.type === "expense");
});

const deleteCategory = (id) => {
    if (confirm("Are you sure you want to delete this category?")) {
        router.delete(route("categories.destroy", id));
    }
};
</script>
