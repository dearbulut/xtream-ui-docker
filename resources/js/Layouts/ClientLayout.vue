<template>
  <div class="min-h-screen bg-gray-900">
    <!-- Header -->
    <header class="bg-gray-800">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
          <!-- Logo -->
          <div class="flex-shrink-0">
            <Link :href="route('client.dashboard')" class="text-white font-bold text-xl">
              XtreamUI
            </Link>
          </div>

          <!-- Navigation -->
          <nav class="hidden md:block">
            <div class="flex space-x-4">
              <Link
                v-for="item in navigation"
                :key="item.name"
                :href="route(item.route)"
                :class="[
                  route().current(item.route)
                    ? 'bg-gray-900 text-white'
                    : 'text-gray-300 hover:bg-gray-700 hover:text-white',
                  'px-3 py-2 rounded-md text-sm font-medium'
                ]"
              >
                {{ item.name }}
              </Link>
            </div>
          </nav>

          <!-- User Menu -->
          <div class="flex items-center">
            <div class="ml-3 relative">
              <div>
                <button
                  @click="showUserMenu = !showUserMenu"
                  class="max-w-xs bg-gray-800 rounded-full flex items-center text-sm focus:outline-none"
                >
                  <span class="sr-only">Open user menu</span>
                  <img
                    class="h-8 w-8 rounded-full"
                    :src="user.avatar || 'https://ui-avatars.com/api/?name=' + user.username"
                    :alt="user.username"
                  >
                </button>
              </div>

              <div
                v-if="showUserMenu"
                class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-gray-700 ring-1 ring-black ring-opacity-5"
              >
                <Link
                  :href="route('client.profile')"
                  class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-600"
                >
                  Your Profile
                </Link>
                <Link
                  :href="route('client.settings')"
                  class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-600"
                >
                  Settings
                </Link>
                <Link
                  :href="route('client.logout')"
                  method="post"
                  as="button"
                  class="block w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-600"
                >
                  Sign out
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
      <slot></slot>
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

const navigation = [
  { name: 'Dashboard', route: 'client.dashboard' },
  { name: 'Live TV', route: 'client.live' },
  { name: 'Movies', route: 'client.movies' },
  { name: 'Series', route: 'client.series' },
  { name: 'TV Guide', route: 'client.guide' },
]

const showUserMenu = ref(false)
const user = usePage().props.auth.user
</script>