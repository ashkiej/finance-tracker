<template>
    <div class="relative">
        <Doughnut v-if="hasData" :data="chartData" :options="chartOptions" />
        <div v-else class="absolute inset-0 flex items-center justify-center">
            <p class="text-gray-500">No spending data for this month</p>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    ArcElement,
    CategoryScale,
} from "chart.js";
import { Doughnut } from "vue-chartjs";

ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale);

const props = defineProps({
    data: Array,
});

const hasData = computed(() => props.data && props.data.length > 0);
const theme = ref(localStorage.getItem("theme") || "system");

const chartData = computed(() => ({
    labels: props.data?.map((item) => item.name) || [],
    datasets: [
        {
            data: props.data?.map((item) => item.total) || [],
            backgroundColor: props.data?.map((item) => item.color) || [],
            borderWidth: 1,
            borderColor: theme.value === "dark" ? "#09090b" : "#ffffff",
        },
    ],
}));

const chartOptions = computed(() => ({
    responsive: true,
    maintainAspectRatio: true,
    aspectRatio: 1,
    plugins: {
        legend: {
            position: "bottom",
            labels: {
                padding: 20,
                usePointStyle: true,
                color: theme.value === "dark" ? "#fafafa" : "#333",
            },
        },
        tooltip: {
            callbacks: {
                label: function (context) {
                    const label = context.label || "";
                    const value = new Intl.NumberFormat("en-US", {
                        style: "currency",
                        currency: "USD",
                    }).format(context.raw);
                    return `${label}: ${value}`;
                },
            },
        },
    },
}));

onMounted(() => {
    window.addEventListener("theme-changed", (e) => {
        theme.value = e.detail.theme;
    });
});
</script>
