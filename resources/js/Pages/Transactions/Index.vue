<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-primary text-xl leading-tight">
                    Transactions
                </h2>
                <Link
                    :href="route('transactions.create')"
                    class="px-4 py-2 bg-primary rounded-md hover:bg-primary/70"
                >
                    Add Transaction
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

                <!-- Filters -->
                <div
                    class="bg-card text-card-foreground overflow-hidden shadow-sm sm:rounded-lg mb-6"
                >
                    <div class="p-6">
                        <form
                            @submit.prevent="applyFilters"
                            class="grid grid-cols-1 md:grid-cols-4 gap-4"
                        >
                            <div>
                                <label class="block text-sm font-medium mb-2"
                                    >Search</label
                                >
                                <input
                                    v-model="filterForm.search"
                                    type="text"
                                    placeholder="Search description..."
                                    class="w-full bg-accent rounded-md shadow-sm"
                                />
                            </div>

                            <div>
                                <label class="block text-sm font-medium = mb-2"
                                    >Type</label
                                >
                                <select
                                    v-model="filterForm.type"
                                    class="w-full bg-accent rounded-md shadow-sm"
                                >
                                    <option value="">All Types</option>
                                    <option value="income">Income</option>
                                    <option value="expense">Expense</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium = mb-2"
                                    >Category</label
                                >
                                <select
                                    v-model="filterForm.category_id"
                                    class="w-full bg-accent rounded-md shadow-sm"
                                >
                                    <option value="">All Categories</option>
                                    <option
                                        v-for="category in categories"
                                        :key="category.id"
                                        :value="category.id"
                                    >
                                        {{ category.name }}
                                    </option>
                                </select>
                            </div>

                            <div class="flex items-end space-x-2">
                                <button
                                    type="submit"
                                    class="px-4 py-2 bg-primary rounded-md hover:bg-primary/80"
                                >
                                    Filter
                                </button>
                                <button
                                    type="button"
                                    @click="clearFilters"
                                    class="px-4 py-2 bg-accent rounded-md hover:bg-accent/10"
                                >
                                    Clear
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Transactions List -->
                <div class="bg-card overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <TransactionList
                            :transactions="transactions.data"
                            :show-actions="true"
                        />

                        <!-- Pagination -->
                        <div
                            class="mt-6 flex justify-between items-center"
                            v-if="transactions.data.length > 0"
                        >
                            <div class="text-sm">
                                Showing {{ transactions.from }} to
                                {{ transactions.to }} of
                                {{ transactions.total }} results
                            </div>
                            <div class="flex space-x-2">
                                <Link
                                    v-for="link in transactions.links"
                                    :key="link.label"
                                    :href="link.url || ''"
                                    :class="[
                                        'px-3 py-2 rounded-md text-sm',
                                        link.active
                                            ? 'bg-primary'
                                            : 'bg-accent hover:bg-accent/10',
                                        !link.url
                                            ? 'opacity-50 cursor-not-allowed'
                                            : '',
                                    ]"
                                    v-html="link.label"
                                    :disabled="!link.url"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, reactive } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import TransactionList from "@/Components/TransactionList.vue";

const props = defineProps({
    transactions: Object,
    categories: Array,
    filters: Object,
});

const filterForm = reactive({
    search: props.filters?.search || "",
    type: props.filters?.type || "",
    category_id: props.filters?.category_id || "",
});

const applyFilters = () => {
    router.get(route("transactions.index"), filterForm, {
        preserveState: true,
        preserveScroll: true,
    });
};

const clearFilters = () => {
    filterForm.search = "";
    filterForm.type = "";
    filterForm.category_id = "";
    applyFilters();
};
</script>
