<script setup>
defineProps({
    title: {
        type: String,
        default: null,
    },
    footer: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <div class="card">
        <div v-if="title" class="card-header">
            <h3 class="text-lg font-medium leading-6 text-gray-900">
                {{ title }}
            </h3>
        </div>
        <div class="card-body">
            <slot />
        </div>
        <div v-if="footer" class="card-footer bg-gray-50">
            <slot name="footer" />
        </div>
    </div>
</template>
