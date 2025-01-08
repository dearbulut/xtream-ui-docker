<template>
  <div class="bg-white p-4 rounded-lg shadow">
    <form @submit.prevent="handleSubmit">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Search -->
        <div>
          <label class="block text-sm font-medium text-gray-700">
            Search
          </label>
          <input
            type="text"
            v-model="form.search"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            placeholder="Search logs..."
          />
        </div>

        <!-- Type -->
        <div>
          <label class="block text-sm font-medium text-gray-700">
            Type
          </label>
          <select
            v-model="form.type"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
          >
            <option value="">All Types</option>
            <option
              v-for="(label, value) in types"
              :key="value"
              :value="value"
            >
              {{ label }}
            </option>
          </select>
        </div>

        <!-- Date Range -->
        <div>
          <label class="block text-sm font-medium text-gray-700">
            From Date
          </label>
          <input
            type="date"
            v-model="form.from_date"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">
            To Date
          </label>
          <input
            type="date"
            v-model="form.to_date"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
          />
        </div>

        <!-- Actions -->
        <div class="flex items-end space-x-2">
          <Button type="submit" class="w-full">
            <template #icon>
              <FilterIcon class="w-4 h-4" />
            </template>
            Filter
          </Button>

          <Button
            type="button"
            @click="resetFilters"
            variant="secondary"
            class="w-full"
          >
            <template #icon>
              <RefreshIcon class="w-4 h-4" />
            </template>
            Reset
          </Button>
        </div>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import Button from '@/Components/Button.vue'
import { FilterIcon, RefreshIcon } from '@heroicons/vue/outline'
import debounce from 'lodash/debounce'

const props = defineProps({
  filters: {
    type: Object,
    default: () => ({}),
  },
  types: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits(['filter'])

const form = ref({
  search: props.filters.search || '',
  type: props.filters.type || '',
  from_date: props.filters.from_date || '',
  to_date: props.filters.to_date || '',
})

const handleSubmit = () => {
  emit('filter', form.value)
}

const resetFilters = () => {
  form.value = {
    search: '',
    type: '',
    from_date: '',
    to_date: '',
  }
  emit('filter', form.value)
}

// Debounced search
watch(
  () => form.value.search,
  debounce((value) => {
    emit('filter', form.value)
  }, 300)
)
</script>