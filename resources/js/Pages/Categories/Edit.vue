<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-primary text-xl leading-tight">
                Edit Category
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-card overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submitForm" class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    Category Type
                                </label>
                                <div
                                    :class="[
                                        'p-4 border-2 rounded-lg',
                                        category.type === 'income'
                                            ? 'border-green-500 bg-success-content'
                                            : 'border-red-500 bg-error-content',
                                    ]"
                                >
                                    <div class="text-2xl mb-2">
                                        {{
                                            category.type === "income"
                                                ? "💰"
                                                : "💸"
                                        }}
                                    </div>
                                    <div class="font-medium capitalize">
                                        {{ category.type }}
                                    </div>
                                </div>
                                <p class="text-xs text-muted-foreground mt-1">
                                    Category type cannot be changed
                                </p>
                            </div>

                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    Category Name *
                                </label>
                                <input
                                    v-model="form.name"
                                    type="text"
                                    placeholder="e.g., Groceries, Salary, Entertainment"
                                    class="w-full bg-accent rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required
                                />
                                <div
                                    v-if="form.errors.name"
                                    class="text-red-600 text-sm mt-1"
                                >
                                    {{ form.errors.name }}
                                </div>
                            </div>

                            <!-- Color -->
                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    Color *
                                </label>
                                <div class="flex space-x-2 items-center">
                                    <input
                                        v-model="form.color"
                                        type="color"
                                        class="h-10 w-20 rounded border-gray-300"
                                        required
                                    />
                                    <span
                                        class="text-sm text-muted-foreground"
                                        >{{ form.color }}</span
                                    >
                                </div>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    <button
                                        v-for="color in presetColors"
                                        :key="color"
                                        type="button"
                                        @click="form.color = color"
                                        class="w-8 h-8 rounded-full border-2 hover:scale-110 transition"
                                        :class="
                                            form.color === color
                                                ? 'border-gray-800'
                                                : 'border-gray-300'
                                        "
                                        :style="{ backgroundColor: color }"
                                    ></button>
                                </div>
                                <div
                                    v-if="form.errors.color"
                                    class="text-red-600 text-sm mt-1"
                                >
                                    {{ form.errors.color }}
                                </div>
                            </div>

                            <!-- Icon -->
                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    Icon *
                                </label>
                                <input
                                    v-model="form.icon"
                                    type="text"
                                    placeholder="cash, shopping-bag, heart"
                                    class="w-full bg-accent rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required
                                />
                                <p class="text-xs text-muted-foreground mt-1">
                                    Use any Heroicons name (e.g., banknotes,
                                    shopping-cart, heart)
                                </p>
                                <div
                                    v-if="form.errors.icon"
                                    class="text-red-600 text-sm mt-1"
                                >
                                    {{ form.errors.icon }}
                                </div>
                            </div>

                            <!-- Preview -->
                            <div class="bg-accent border rounded-lg p-4">
                                <p class="text-sm font-medium mb-2">Preview</p>
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-12 h-12 rounded-full flex items-center justify-center"
                                        :style="{ backgroundColor: form.color }"
                                    >
                                        <span class="text-white text-xl">{{
                                            category.type === "income"
                                                ? "💰"
                                                : "💸"
                                        }}</span>
                                    </div>
                                    <div>
                                        <p class="font-medium">
                                            {{ form.name }}
                                        </p>
                                        <p class="text-sm capitalize">
                                            {{ category.type }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="flex justify-end space-x-3">
                                <Link
                                    :href="route('categories.index')"
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
                                            ? "Updating..."
                                            : "Update Category"
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
    category: Object,
});

const form = useForm({
    name: props.category.name,
    color: props.category.color,
    icon: props.category.icon,
});

const presetColors = [
    "#EF4444",
    "#F59E0B",
    "#10B981",
    "#3B82F6",
    "#6366F1",
    "#8B5CF6",
    "#EC4899",
    "#F97316",
    "#14B8A6",
    "#06B6D4",
    "#84CC16",
    "#F43F5E",
];

const submitForm = () => {
    form.put(route("categories.update", props.category.id));
};
</script>
