<template>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <component
                        :is="iconComponent"
                        :class="`h-6 w-6 text-${color}-600`"
                    />
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">
                            {{ title }}
                        </dt>
                        <dd class="text-lg font-medium text-gray-900">
                            {{
                                formatCurreny
                                    ? formatCurrency(value)
                                    : formatNumber(value)
                            }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";
import {
    ArrowUpIcon,
    ArrowDownIcon,
    BanknotesIcon,
    ListBulletIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    title: String,
    value: Number,
    color: String,
    icon: String,
    formatCurreny: {
        type: Boolean,
        default: true,
    },
});

const iconComponents = {
    "arrow-up": ArrowUpIcon,
    "arrow-down": ArrowDownIcon,
    banknotes: BanknotesIcon,
    "list-bullet": ListBulletIcon,
};

const iconComponent = computed(() => iconComponents[props.icon]);

const formatCurrency = (amount) => {
    return new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
    }).format(amount || 0);
};

const formatNumber = (amount) => {
    return new Intl.NumberFormat("en-US").format(amount || 0);
};
</script>
