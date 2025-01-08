<script setup>
import { ref, computed, watch } from 'vue';
import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue';
import { CalendarIcon } from '@heroicons/vue/24/outline';
import { format, parse, isValid, startOfMonth, endOfMonth, eachDayOfInterval, startOfWeek, endOfWeek, isSameMonth, isSameDay, addMonths, subMonths } from 'date-fns';

const props = defineProps({
    modelValue: {
        type: [String, Date, null],
        default: null,
    },
    label: {
        type: String,
        required: true,
    },
    error: {
        type: String,
        default: '',
    },
});

const emit = defineEmits(['update:modelValue']);

const currentMonth = ref(props.modelValue ? new Date(props.modelValue) : new Date());
const selectedDate = ref(props.modelValue ? new Date(props.modelValue) : null);

watch(() => props.modelValue, (newValue) => {
    selectedDate.value = newValue ? new Date(newValue) : null;
});

watch(selectedDate, (newValue) => {
    emit('update:modelValue', newValue ? format(newValue, 'yyyy-MM-dd') : null);
});

const days = computed(() => {
    const start = startOfWeek(startOfMonth(currentMonth.value));
    const end = endOfWeek(endOfMonth(currentMonth.value));
    return eachDayOfInterval({ start, end });
});

const previousMonth = () => {
    currentMonth.value = subMonths(currentMonth.value, 1);
};

const nextMonth = () => {
    currentMonth.value = addMonths(currentMonth.value, 1);
};

const isSelected = (day) => {
    return selectedDate.value && isSameDay(day, selectedDate.value);
};

const isToday = (day) => {
    return isSameDay(day, new Date());
};

const selectDate = (day) => {
    selectedDate.value = day;
};

const clearDate = () => {
    selectedDate.value = null;
};
</script>

<template>
    <div>
        <label v-if="label" class="block text-sm font-medium text-gray-700 mb-1">
            {{ label }}
        </label>

        <Popover class="relative">
            <PopoverButton
                class="w-full inline-flex justify-between items-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
            >
                <span v-if="selectedDate">
                    {{ format(selectedDate, 'MMMM d, yyyy') }}
                </span>
                <span v-else class="text-gray-400">
                    Select a date
                </span>
                <CalendarIcon class="ml-2 h-5 w-5 text-gray-400" aria-hidden="true" />
            </PopoverButton>

            <PopoverPanel class="absolute z-10 mt-1 w-full rounded-md bg-white shadow-lg">
                <div class="p-4">
                    <div class="flex items-center justify-between mb-4">
                        <button
                            type="button"
                            class="p-2 rounded-full hover:bg-gray-100"
                            @click="previousMonth"
                        >
                            <svg class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <div class="text-sm font-medium text-gray-900">
                            {{ format(currentMonth, 'MMMM yyyy') }}
                        </div>
                        <button
                            type="button"
                            class="p-2 rounded-full hover:bg-gray-100"
                            @click="nextMonth"
                        >
                            <svg class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-7 gap-1">
                        <div
                            v-for="day in ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']"
                            :key="day"
                            class="text-xs font-medium text-gray-500 text-center py-1"
                        >
                            {{ day }}
                        </div>

                        <button
                            v-for="day in days"
                            :key="day"
                            type="button"
                            @click="selectDate(day)"
                            :class="[
                                'text-sm rounded-full w-8 h-8 flex items-center justify-center',
                                !isSameMonth(day, currentMonth) && 'text-gray-400',
                                isSameMonth(day, currentMonth) && !isSelected(day) && !isToday(day) && 'text-gray-900 hover:bg-gray-100',
                                isToday(day) && !isSelected(day) && 'text-primary-600 font-semibold',
                                isSelected(day) && 'bg-primary-600 text-white font-semibold hover:bg-primary-700',
                            ]"
                        >
                            {{ format(day, 'd') }}
                        </button>
                    </div>

                    <div class="mt-4 text-right">
                        <button
                            type="button"
                            class="text-sm text-gray-600 hover:text-gray-900"
                            @click="clearDate"
                        >
                            Clear
                        </button>
                    </div>
                </div>
            </PopoverPanel>
        </Popover>

        <p v-if="error" class="mt-2 text-sm text-red-600">{{ error }}</p>
    </div>
</template>