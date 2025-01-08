<template>
  <div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Type
                </th>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Description
                </th>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  User
                </th>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  IP Address
                </th>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Date
                </th>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Details
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-if="loading">
                <td colspan="6" class="px-6 py-4 text-center">
                  <LoadingSpinner />
                </td>
              </tr>
              <tr v-else-if="!logs.length">
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                  No activity logs found.
                </td>
              </tr>
              <tr v-for="log in logs" :key="log.id">
                <td class="px-6 py-4 whitespace-nowrap">
                  <Badge :color="log.type.color">
                    {{ log.type.text }}
                  </Badge>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm text-gray-900">
                    {{ log.description }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div v-if="log.user.avatar" class="flex-shrink-0 h-8 w-8">
                      <img
                        class="h-8 w-8 rounded-full"
                        :src="log.user.avatar"
                        :alt="log.user.name"
                      />
                    </div>
                    <div class="ml-2">
                      <div class="text-sm font-medium text-gray-900">
                        {{ log.user.name }}
                      </div>
                      <div class="text-sm text-gray-500">
                        {{ log.user.email }}
                      </div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ log.ip_address }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">
                    {{ log.time_ago }}
                  </div>
                  <div class="text-sm text-gray-500">
                    {{ log.created_at }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <Button
                    variant="secondary"
                    @click="showDetails(log)"
                  >
                    <template #icon>
                      <InformationCircleIcon class="w-4 h-4" />
                    </template>
                    Details
                  </Button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Details Modal -->
    <Modal
      :show="!!selectedLog"
      @close="selectedLog = null"
      :title="selectedLog?.type?.text"
    >
      <div class="space-y-4">
        <div>
          <h4 class="text-sm font-medium text-gray-500">Description</h4>
          <p class="mt-1 text-sm text-gray-900">
            {{ selectedLog?.description }}
          </p>
        </div>

        <div>
          <h4 class="text-sm font-medium text-gray-500">User Agent</h4>
          <p class="mt-1 text-sm text-gray-900">
            {{ selectedLog?.user_agent }}
          </p>
        </div>

        <div v-if="selectedLog?.metadata">
          <h4 class="text-sm font-medium text-gray-500">Metadata</h4>
          <pre class="mt-1 text-sm text-gray-900 bg-gray-50 p-4 rounded-md overflow-auto">
            {{ JSON.stringify(selectedLog.metadata, null, 2) }}
          </pre>
        </div>
      </div>
    </Modal>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Badge from '@/Components/Badge.vue'
import Button from '@/Components/Button.vue'
import LoadingSpinner from '@/Components/LoadingSpinner.vue'
import Modal from '@/Components/Modal.vue'
import { InformationCircleIcon } from '@heroicons/vue/outline'

defineProps({
  logs: {
    type: Array,
    required: true,
  },
  loading: {
    type: Boolean,
    default: false,
  },
})

const selectedLog = ref(null)

const showDetails = (log) => {
  selectedLog.value = log
}
</script>