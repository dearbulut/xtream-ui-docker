<script setup>
import { computed } from "vue";
import {
    CheckCircleIcon,
    ExclamationTriangleIcon,
    InformationCircleIcon,
    XCircleIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    type: {
        type: String,
        default: "info",
        validator: (value) => ["success", "error", "warning", "info"].includes(value),
    },
    title: {
        type: String,
        default: null,
    },
    dismissible: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["dismiss"]);

const icon = computed(() => {
    switch (props.type) {
        case "success":
            return CheckCircleIcon;
        case "error":
            return XCircleIcon;
        case "warning":
            return ExclamationTriangleIcon;
        default:
            return InformationCircleIcon;
    }
});

const classes = computed(() => {
    const base = "rounded-md p-4";
    const variants = {
        success: "bg-green-50 text-green-800",
        error: "bg-red-50 text-red-800",
        warning: "bg-yellow-50 text-yellow-800",
        info: "bg-blue-50 text-blue-800",
    };
    return `${base} ${variants[props.type]}`;
});

const iconClasses = computed(() => {
    const variants = {
        success: "text-green-400",
        error: "text-red-400",
        warning: "text-yellow-400",
        info: "text-blue-400",
    };
    return `h-5 w-5 ${variants[props.type]}`;
});
</script>

<template>
    <div :class="classes">
        <div class="flex">
            <div class="flex-shrink-0">
                <component :is="icon" :class="iconClasses" aria-hidden="true" />
            </div>
            <div class="ml-3">
                <h3 v-if="title" class="text-sm font-medium">
                    {{ title }}
                </h3>
                <div class="text-sm">
                    <slot />
                </div>
            </div>
            <div v-if="dismissible" class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button
                        type="button"
                        :class="[
                            'inline-flex rounded-md p-1.5',
                            {
                                'bg-green-50 text-green-500 hover:bg-green-100': type === 'success',
                                'bg-red-50 text-red-500 hover:bg-red-100': type === 'error',
                                'bg-yellow-50 text-yellow-500 hover:bg-yellow-100': type === 'warning',
                                'bg-blue-50 text-blue-500 hover:bg-blue-100': type === 'info',
                            },
                        ]"
                        @click="$emit('dismiss')"
                    >
                        <span class="sr-only">Dismiss</span>
                        <XCircleIcon class="h-5 w-5" aria-hidden="true" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>