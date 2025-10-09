<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";

const particlesOptions = {
    background: { color: { value: "#0f172a" } },
    fpsLimit: 60,
    particles: {
        color: { value: "#ffffff" },
        links: {
            color: "#ffffff",
            distance: 150,
            enable: true,
            opacity: 0.4,
            width: 1,
        },
        move: {
            direction: "none",
            enable: true,
            outModes: "bounce",
            speed: 1,
        },
        number: {
            density: { enable: true, area: 800 },
            value: 60,
        },
        opacity: { value: 0.5 },
        shape: { type: "circle" },
        size: { value: { min: 1, max: 5 } },
    },
    detectRetina: true,
};
</script>

<template>
    <div
        class="relative min-h-screen flex flex-col items-center justify-center overflow-hidden"
    >
        <vue-particles
            id="tsparticles"
            class="absolute inset-0"
            :options="particlesOptions"
        />

        <div
            class="relative z-10 flex flex-col items-center pt-6 sm:justify-center sm:pt-0"
        >
            <div>
                <Link href="/">
                    <ApplicationLogo
                        class="h-20 w-60 fill-current text-white drop-shadow-lg"
                    />
                </Link>
            </div>

            <div
                class="mt-6 w-full overflow-hidden bg-white/90 px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg backdrop-blur-sm"
            >
                <slot />
            </div>
        </div>
    </div>
</template>
