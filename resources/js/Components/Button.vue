<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    type: {
        type: String,
        default: "button",
    },
    variant: {
        type: String,
        default: "primary",
        validator: (value) => ["primary", "secondary", "success", "danger", "warning", "info"].includes(value),
    },
    size: {
        type: String,
        default: "md",
        validator: (value) => ["sm", "md", "lg"].includes(value),
    },
    href: {
        type: String,
        default: null,
    },
    method: {
        type: String,
        default: "get",
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});

const classes = computed(() => {
    return [
        "btn",
        `btn-${props.variant}`,
        props.size !== "md" && `btn-${props.size}`,
        props.disabled && "opacity-50 cursor-not-allowed",
    ];
});
</script>

<template>
    <Link v-if="href" :href="href" :method="method" :class="classes">
        <slot />
    </Link>
    <button v-else :type="type" :disabled="disabled" :class="classes">
        <slot />
    </button>
</template>
