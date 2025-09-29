<script setup>
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import NavLink from "@/Components/NavLink.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { Link } from "@inertiajs/vue3";

const sidebarOpen = ref(false);
</script>

<template>
    <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside
            :class="[
                'fixed inset-y-0 left-0 z-50 w-64 bg-white border-r transform transition-transform duration-200 ease-in-out',
                sidebarOpen ? 'translate-x-0' : '-translate-x-full',
                'md:translate-x-0',
            ]"
        >
            <div class="flex items-center justify-between px-4 py-4 border-b">
                <Link :href="route('dashboard')">
                    <ApplicationLogo class="h-8 w-auto text-gray-800" />
                </Link>
                <!-- Close button on mobile -->
                <button
                    @click="sidebarOpen = false"
                    class="md:hidden p-2 text-gray-500 hover:bg-gray-100 rounded"
                >
                    ✕
                </button>
            </div>

            <nav class="mt-4 space-y-2 px-4">
                <NavLink
                    sidebar
                    :href="route('dashboard')"
                    :active="route().current('dashboard')"
                >
                    Dashboard
                </NavLink>
                <NavLink
                    sidebar
                    :href="route('transactions.index')"
                    :active="route().current('transactions.*')"
                >
                    Transactions
                </NavLink>
                <NavLink
                    sidebar
                    :href="route('categories.index')"
                    :active="route().current('categories.*')"
                >
                    Categories
                </NavLink>
                <NavLink
                    sidebar
                    :href="route('budgets.index')"
                    :active="route().current('budgets.*')"
                >
                    Budgets
                </NavLink>
            </nav>
            <footer
                class="mt-auto px-4 py-4 text-xs text-gray-400 border-t text-center"
            >
                <Dropdown width="48">
                    <template #trigger>
                        <button
                            type="button"
                            class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-lg font-medium text-gray-500 hover:text-gray-700"
                        >
                            {{ $page.props.auth.user.name }}
                            <svg
                                class="ml-1 h-4 w-4"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414
                       1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0
                       010-1.414z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </button>
                    </template>
                    <template #content>
                        <DropdownLink :href="route('profile.edit')"
                            >Profile</DropdownLink
                        >
                        <DropdownLink
                            :href="route('logout')"
                            method="post"
                            as="button"
                        >
                            Log Out
                        </DropdownLink>
                    </template>
                </Dropdown>
            </footer>
        </aside>

        <!-- Main content -->
        <div class="flex flex-1 flex-col md:ml-64">
            <!-- Top Navbar -->
            <!-- <nav
                class="flex items-center justify-between md:justify-end bg-white border-b px-4 h-16"
            > -->
            <!-- Mobile menu button -->
            <!-- <button
                    @click="sidebarOpen = true"
                    class="md:hidden p-2 text-gray-500 hover:bg-gray-100 rounded"
                >
                    ☰
                </button> -->

            <!-- Right side dropdown -->
            <!-- <div class="flex items-center space-x-4">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button
                                type="button"
                                class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700"
                            >
                                {{ $page.props.auth.user.name }}
                                <svg
                                    class="ml-1 h-4 w-4"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414
                       1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0
                       010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </button>
                        </template>
                        <template #content>
                            <DropdownLink :href="route('profile.edit')"
                                >Profile</DropdownLink
                            >
                            <DropdownLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </nav> -->

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="mx-auto max-w-7xl px-4 py-3 sm:px-6 lg:px-8">
                    <button
                        @click="sidebarOpen = true"
                        class="md:hidden p-2 text-gray-500 hover:bg-gray-100 rounded"
                    >
                        ☰
                    </button>
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4">
                <slot />
            </main>
        </div>
    </div>
</template>
