<script setup>
import { ref, computed, watch } from 'vue';
import { Combobox, ComboboxInput, ComboboxButton, ComboboxOptions, ComboboxOption, TransitionRoot } from '@headlessui/vue';
import { ChevronUpDownIcon, XMarkIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    modelValue: {
        type: Array,
        default: () => [],
    },
    options: {
        type: Array,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    error: {
        type: String,
        default: '',
    },
    valueKey: {
        type: String,
        default: 'id',
    },
    labelKey: {
        type: String,
        default: 'name',
    },
});

const emit = defineEmits(['update:modelValue']);

const query = ref('');
const selectedItems = ref(props.modelValue);

watch(() => props.modelValue, (newValue) => {
    selectedItems.value = newValue;
});

watch(selectedItems, (newValue) => {
    emit('update:modelValue', newValue);
});

const filteredOptions = computed(() => {
    return query.value === ''
        ? props.options
        : props.options.filter((option) =>
            option[props.labelKey]
                .toLowerCase()
                .replace(/\s+/g, '')
                .includes(query.value.toLowerCase().replace(/\s+/g, ''))
        );
});

const selectedLabels = computed(() => {
    return props.options
        .filter(option => selectedItems.value.includes(option[props.valueKey]))
        .map(option => option[props.labelKey]);
});

const removeItem = (index) => {
    const newItems = [...selectedItems.value];
    newItems.splice(index, 1);
    selectedItems.value = newItems;
};
</script>

<template>
    <div>
        <label v-if="label" class="block text-sm font-medium text-gray-700 mb-1">
            {{ label }}
        </label>

        <div class="relative">
            <Combobox v-model="selectedItems" multiple>
                <div class="relative">
                    <div class="relative w-full cursor-default overflow-hidden rounded-lg bg-white text-left border border-gray-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75 focus-visible:ring-offset-2 focus-visible:ring-offset-primary-300 sm:text-sm">
                        <div class="flex flex-wrap gap-2 p-1">
                            <div
                                v-for="(label, index) in selectedLabels"
                                :key="index"
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800"
                            >
                                {{ label }}
                                <button
                                    type="button"
                                    class="flex-shrink-0 ml-0.5 h-4 w-4 rounded-full inline-flex items-center justify-center text-primary-400 hover:bg-primary-200 hover:text-primary-500 focus:outline-none focus:bg-primary-500 focus:text-white"
                                    @click.stop="removeItem(index)"
                                >
                                    <span class="sr-only">Remove</span>
                                    <XMarkIcon class="h-3 w-3" aria-hidden="true" />
                                </button>
                            </div>
                            <ComboboxInput
                                class="w-full border-none py-2 pl-3 pr-10 text-sm leading-5 text-gray-900 focus:ring-0"
                                :displayValue="() => ''"
                                @change="query = $event.target.value"
                                placeholder="Search..."
                            />
                        </div>
                        <ComboboxButton class="absolute inset-y-0 right-0 flex items-center pr-2">
                            <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                        </ComboboxButton>
                    </div>

                    <TransitionRoot
                        leave="transition ease-in duration-100"
                        leaveFrom="opacity-100"
                        leaveTo="opacity-0"
                        @after-leave="query = ''"
                    >
                        <ComboboxOptions class="absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm z-10">
                            <div
                                v-if="filteredOptions.length === 0 && query !== ''"
                                class="relative cursor-default select-none py-2 px-4 text-gray-700"
                            >
                                Nothing found.
                            </div>

                            <ComboboxOption
                                v-for="option in filteredOptions"
                                :key="option[valueKey]"
                                :value="option[valueKey]"
                                v-slot="{ selected, active }"
                            >
                                <div
                                    :class="[
                                        'relative cursor-default select-none py-2 pl-10 pr-4',
                                        active ? 'bg-primary-600 text-white' : 'text-gray-900',
                                    ]"
                                >
                                    <span
                                        :class="[
                                            'block truncate',
                                            selected ? 'font-medium' : 'font-normal',
                                        ]"
                                    >
                                        {{ option[labelKey] }}
                                    </span>
                                    <span
                                        v-if="selected"
                                        :class="[
                                            'absolute inset-y-0 left-0 flex items-center pl-3',
                                            active ? 'text-white' : 'text-primary-600',
                                        ]"
                                    >
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </div>
                            </ComboboxOption>
                        </ComboboxOptions>
                    </TransitionRoot>
                </div>
            </Combobox>
        </div>

        <p v-if="error" class="mt-2 text-sm text-red-600">{{ error }}</p>
    </div>
</template>