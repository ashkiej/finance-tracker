<script setup>
import { useForm } from "@inertiajs/vue3";
import { Moon, Sun, Laptop } from "lucide-vue-next";
import { onMounted, ref, watch } from "vue";

const theme = ref(localStorage.getItem("theme") || "system");
const form = useForm({
    theme: theme.value,
});

const applyTheme = (newTheme) => {
    const root = document.documentElement;
    const isDark =
        newTheme === "dark" ||
        (newTheme === "system" &&
            window.matchMedia("(prefers-color-scheme: dark)").matches);

    if (isDark) {
        root.classList.add("dark");
    } else {
        root.classList.remove("dark");
    }
    // document.documentElement.classList.toggle("dark", isDark);
    localStorage.setItem("theme", newTheme);

    theme.value = newTheme;
};

const setTheme = (newTheme) => {
    applyTheme(newTheme);
    form.theme = newTheme;
    form.post(route("profile.theme.update"), {
        preserveState: true,
        preserveScroll: true,
    });
};

onMounted(() => {
    applyTheme(theme.value);

    window
        .matchMedia("(prefers-color-scheme: dark)")
        .addEventListener("change", (e) => {
            if (theme.value === "system") {
                applyTheme("system");
            }
        });
});

watch(theme, (newTheme) => {
    applyTheme(newTheme);
});
</script>

<template>
    <div class="flex items-center space-x-2">
        <button
            @click="setTheme('light')"
            :class="{ 'bg-gray-200 dark:bg-gray-700': theme === 'light' }"
            class="p-2 rounded-md"
        >
            <Sun class="w-5 h-5" />
        </button>
        <button
            @click="setTheme('dark')"
            :class="{ 'bg-gray-200 dark:bg-gray-700': theme === 'dark' }"
            class="p-2 rounded-md"
        >
            <Moon class="w-5 h-5" />
        </button>
        <button
            @click="setTheme('system')"
            :class="{ 'bg-gray-200 dark:bg-gray-700': theme === 'system' }"
            class="p-2 rounded-md"
        >
            <Laptop class="w-5 h-5" />
        </button>
    </div>
</template>
