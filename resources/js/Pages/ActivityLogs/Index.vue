<template>
  <AdminLayout title="Activity Logs">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Activity Logs
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <!-- Filters -->
            <div class="mb-6">
              <ActivityLogFilters
                :filters="filters"
                :types="types"
                @filter="handleFilter"
              />
            </div>

            <!-- Stats -->
            <div class="mb-6">
              <ActivityLogStats :stats="stats" />
            </div>

            <!-- Actions -->
            <div class="mb-6 flex justify-end space-x-4">
              <Button
                v-if="can.export"
                @click="handleExport"
                :disabled="exporting"
              >
                <template #icon>
                  <DownloadIcon class="w-4 h-4" />
                </template>
                {{ exporting ? 'Exporting...' : 'Export' }}
              </Button>

              <Button
                v-if="can.cleanup"
                @click="handleCleanup"
                :disabled="cleaning"
                variant="danger"
              >
                <template #icon>
                  <TrashIcon class="w-4 h-4" />
                </template>
                {{ cleaning ? 'Cleaning...' : 'Cleanup' }}
              </Button>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
              <ActivityLogTable
                :logs="logs.data"
                :loading="loading"
              />
            </div>

            <!-- Pagination -->
            <div class="mt-6">
              <Pagination :links="logs.meta.links" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import ActivityLogFilters from '@/Components/ActivityLogs/Filters.vue'
import ActivityLogStats from '@/Components/ActivityLogs/Stats.vue'
import ActivityLogTable from '@/Components/ActivityLogs/Table.vue'
import Button from '@/Components/Button.vue'
import Pagination from '@/Components/Pagination.vue'
import { DownloadIcon, TrashIcon } from '@heroicons/vue/outline'
import { useToast } from '@/Composables/useToast'
import axios from 'axios'

const props = defineProps({
  logs: Object,
  filters: Object,
  types: Object,
  stats: Object,
  can: Object,
})

const loading = ref(false)
const exporting = ref(false)
const cleaning = ref(false)
const { showToast } = useToast()

const handleFilter = (newFilters) => {
  loading.value = true
  Inertia.get(
    route('activity-logs.index'),
    { ...newFilters },
    {
      preserveState: true,
      preserveScroll: true,
      onFinish: () => {
        loading.value = false
      },
    }
  )
}

const handleExport = async () => {
  try {
    exporting.value = true
    await axios.post(route('activity-logs.export'), props.filters)
    showToast({
      type: 'success',
      message: 'Export started. You will be notified when it is completed.',
    })
  } catch (error) {
    showToast({
      type: 'error',
      message: 'Failed to start export.',
    })
  } finally {
    exporting.value = false
  }
}

const handleCleanup = async () => {
  if (!confirm('Are you sure you want to clean up old activity logs?')) {
    return
  }

  try {
    cleaning.value = true
    const response = await axios.post(route('activity-logs.cleanup'))
    showToast({
      type: 'success',
      message: response.data.message,
    })
    Inertia.reload()
  } catch (error) {
    showToast({
      type: 'error',
      message: 'Failed to clean up activity logs.',
    })
  } finally {
    cleaning.value = false
  }
}
</script>