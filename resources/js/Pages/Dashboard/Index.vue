<template>
  <AdminLayout>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
      <!-- Kullanıcı İstatistikleri -->
      <StatCard
        title="Total Users"
        :value="stats.total_users.count"
        icon="users"
        color="blue"
      >
        <template #footer>
          <div class="flex justify-between text-sm">
            <span>Active: {{ stats.total_users.active }}</span>
            <span>Online: {{ stats.total_users.online }}</span>
          </div>
        </template>
      </StatCard>

      <!-- İçerik İstatistikleri -->
      <StatCard
        title="Total Content"
        :value="stats.content_stats.channels + stats.content_stats.movies + stats.content_stats.series"
        icon="play-circle"
        color="green"
      >
        <template #footer>
          <div class="flex justify-between text-sm">
            <span>Channels: {{ stats.content_stats.channels }}</span>
            <span>VOD: {{ stats.content_stats.movies + stats.content_stats.series }}</span>
          </div>
        </template>
      </StatCard>

      <!-- Sistem Durumu -->
      <StatCard
        title="System Status"
        :value="stats.system_status.uptime"
        icon="server"
        color="purple"
      >
        <template #footer>
          <div class="flex justify-between text-sm">
            <span>CPU: {{ stats.system_status.cpu_usage }}%</span>
            <span>RAM: {{ stats.system_status.memory_usage }}%</span>
          </div>
        </template>
      </StatCard>

      <!-- Bouquet İstatistikleri -->
      <StatCard
        title="Active Bouquets"
        :value="stats.content_stats.bouquets"
        icon="package"
        color="orange"
      >
        <template #footer>
          <div class="flex justify-between text-sm">
            <span>Trial: {{ stats.total_users.trial }}</span>
            <span>Expiring: {{ stats.expiring_soon.length }}</span>
          </div>
        </template>
      </StatCard>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
      <!-- Grafik -->
      <ChartCard title="Usage Statistics" class="col-span-1">
        <LineChart
          :chart-data="chart_data"
          :options="{
            responsive: true,
            maintainAspectRatio: false,
          }"
        />
      </ChartCard>

      <!-- Popüler Kanallar -->
      <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold mb-4">Popular Channels</h3>
        <div class="space-y-4">
          <div v-for="channel in stats.popular_channels" :key="channel.id" 
               class="flex items-center space-x-4 p-3 hover:bg-gray-50 rounded-lg transition">
            <img :src="channel.logo" :alt="channel.name" class="w-10 h-10 rounded-full object-cover">
            <div class="flex-1">
              <h4 class="font-medium">{{ channel.name }}</h4>
              <p class="text-sm text-gray-500">{{ channel.views }} views</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <!-- Son Kullanıcılar -->
      <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold mb-4">Recent Users</h3>
        <div class="space-y-4">
          <div v-for="user in stats.recent_users" :key="user.id" 
               class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition">
            <div class="flex items-center space-x-4">
              <div :class="['w-2 h-2 rounded-full', user.is_active ? 'bg-green-500' : 'bg-red-500']"></div>
              <div>
                <h4 class="font-medium">{{ user.username }}</h4>
                <p class="text-sm text-gray-500">Created {{ formatDate(user.created_at) }}</p>
              </div>
            </div>
            <div class="text-sm" :class="getExpiryClass(user.expires_at)">
              {{ formatExpiry(user.expires_at) }}
            </div>
          </div>
        </div>
      </div>

      <!-- Yakında Süresi Dolacaklar -->
      <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold mb-4">Expiring Soon</h3>
        <div class="space-y-4">
          <div v-for="user in stats.expiring_soon" :key="user.id" 
               class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition">
            <div>
              <h4 class="font-medium">{{ user.username }}</h4>
              <p class="text-sm text-gray-500">Expires in {{ formatTimeToExpiry(user.expires_at) }}</p>
            </div>
            <Link :href="route('playlists.edit', user.id)" 
                  class="px-3 py-1 text-sm bg-blue-50 text-blue-600 rounded-full hover:bg-blue-100 transition">
              Renew
            </Link>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import StatCard from '@/Components/Dashboard/StatCard.vue'
import ChartCard from '@/Components/Dashboard/ChartCard.vue'
import LineChart from '@/Components/Charts/LineChart.vue'
import { formatDistanceToNow, format, parseISO } from 'date-fns'

const props = defineProps({
  stats: Object,
  chart_data: Object,
})

const formatDate = (date) => {
  return format(parseISO(date), 'MMM d, yyyy')
}

const formatExpiry = (date) => {
  if (!date) return 'Never'
  return format(parseISO(date), 'MMM d, yyyy')
}

const formatTimeToExpiry = (date) => {
  return formatDistanceToNow(parseISO(date))
}

const getExpiryClass = (date) => {
  if (!date) return 'text-gray-500'
  const daysToExpiry = (parseISO(date) - new Date()) / (1000 * 60 * 60 * 24)
  if (daysToExpiry < 3) return 'text-red-500'
  if (daysToExpiry < 7) return 'text-yellow-500'
  return 'text-green-500'
}
</script>