<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 w-64 bg-white shadow-sm z-20">
      <div class="flex items-center justify-between h-16 px-4 border-b">
        <Link :href="route('dashboard')" class="text-xl font-bold text-gray-900">
          XtreamUI
        </Link>
        <button @click="isSidebarOpen = !isSidebarOpen" class="lg:hidden">
          <i class="fas fa-bars"></i>
        </button>
      </div>

      <nav class="px-4 py-4 space-y-1">
        <Link :href="route('dashboard')" 
              class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg"
              :class="{ 'bg-blue-50 text-blue-700': route().current('dashboard') }">
          <i class="fas fa-home w-5 h-5 mr-3"></i>
          <span>Dashboard</span>
        </Link>

        <Link :href="route('channels.index')"
              class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg"
              :class="{ 'bg-blue-50 text-blue-700': route().current('channels.*') }">
          <i class="fas fa-tv w-5 h-5 mr-3"></i>
          <span>Channels</span>
        </Link>

        <Link :href="route('movies.index')"
              class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg"
              :class="{ 'bg-blue-50 text-blue-700': route().current('movies.*') }">
          <i class="fas fa-film w-5 h-5 mr-3"></i>
          <span>Movies</span>
        </Link>

        <Link :href="route('series.index')"
              class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg"
              :class="{ 'bg-blue-50 text-blue-700': route().current('series.*') }">
          <i class="fas fa-video w-5 h-5 mr-3"></i>
          <span>Series</span>
        </Link>

        <Link :href="route('bouquets.index')"
              class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg"
              :class="{ 'bg-blue-50 text-blue-700': route().current('bouquets.*') }">
          <i class="fas fa-box w-5 h-5 mr-3"></i>
          <span>Bouquets</span>
        </Link>

        <Link :href="route('playlists.index')"
              class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg"
              :class="{ 'bg-blue-50 text-blue-700': route().current('playlists.*') }">
          <i class="fas fa-users w-5 h-5 mr-3"></i>
          <span>Users</span>
        </Link>

        <Link :href="route('settings.index')"
              class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg"
              :class="{ 'bg-blue-50 text-blue-700': route().current('settings.*') }">
          <i class="fas fa-cog w-5 h-5 mr-3"></i>
          <span>Settings</span>
        </Link>
      </nav>
    </aside>

    <!-- Main Content -->
    <div class="lg:pl-64">
      <!-- Top Navigation -->
      <header class="flex items-center justify-between h-16 px-4 bg-white shadow-sm">
        <div class="flex items-center space-x-4">
          <button @click="isSidebarOpen = !isSidebarOpen" class="lg:hidden">
            <i class="fas fa-bars"></i>
          </button>
          <h1 class="text-xl font-semibold">{{ title }}</h1>
        </div>

        <div class="flex items-center space-x-4">
          <div class="relative">
            <button @click="isNotificationsOpen = !isNotificationsOpen" 
                    class="p-2 text-gray-500 hover:text-gray-700">
              <i class="fas fa-bell"></i>
              <span v-if="notifications.length" 
                    class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full">
              </span>
            </button>

            <div v-if="isNotificationsOpen" 
                 class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg py-2">
              <div v-for="notification in notifications" :key="notification.id"
                   class="px-4 py-2 hover:bg-gray-50">
                {{ notification.message }}
              </div>
              <div v-if="!notifications.length" class="px-4 py-2 text-gray-500">
                No new notifications
              </div>
            </div>
          </div>

          <div class="relative">
            <button @click="isProfileOpen = !isProfileOpen"
                    class="flex items-center space-x-2">
              <img :src="user.avatar" alt="" class="w-8 h-8 rounded-full">
              <span>{{ user.name }}</span>
            </button>

            <div v-if="isProfileOpen"
                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2">
              <Link :href="route('profile.edit')"
                    class="block px-4 py-2 text-gray-700 hover:bg-gray-50">
                Profile
              </Link>
              <Link :href="route('logout')" method="post" as="button"
                    class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-50">
                Logout
              </Link>
            </div>
          </div>
        </div>
      </header>

      <!-- Page Content -->
      <main class="p-6">
        <slot></slot>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

const props = defineProps({
  title: {
    type: String,
    default: 'Dashboard'
  }
})

const isSidebarOpen = ref(false)
const isNotificationsOpen = ref(false)
const isProfileOpen = ref(false)

const user = usePage().props.auth.user
const notifications = ref([])
</script>