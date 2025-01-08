<script setup>
import { computed } from "vue";

const props = defineProps({
    modelValue: {
        type: [String, Number, Array],
        default: "",
    },
    options: {
        type: Array,
        required: true,
    },
    label: {
        type: String,
        default: null,
    },
    error: {
        type: String,
        default: null,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    multiple: {
        type: Boolean,
        default: false,
    },
    valueKey: {
        type: String,
        default: "value",
    },
    labelKey: {
        type: String,
        default: "label",
    },
});

const emit = defineEmits(["update:modelValue"]);

const selectClasses = computed(() => {
    return [
        props.error && "border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500",
        props.disabled && "bg-gray-100 cursor-not-allowed",
    ];
});

const handleChange = (event) => {
    if (props.multiple) {
        const values = Array.from(event.target.selectedOptions).map(option => option.value);
        emit("update:modelValue", values);
    } else {
        emit("update:modelValue", event.target.value);
    }
};
</script>

<template>
    <div>
        <label v-if="label" class="block text-sm font-medium text-gray-700">
            {{ label }}
        </label>
        <div class="mt-1">
            <select
                :value="modelValue"
                @change="handleChange"
                :disabled="disabled"
                :multiple="multiple"
                :class="selectClasses"
            >
                <option v-for="option in options" :key="option[valueKey]" :value="option[valueKey]">
                    {{ option[labelKey] }}
                </option>
            </select>
        </div>
        <p v-if="error" class="mt-2 text-sm text-red-600">{{ error }}</p>
    </div>
</template>