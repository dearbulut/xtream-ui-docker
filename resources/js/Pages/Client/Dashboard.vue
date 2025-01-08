<template>
  <ClientLayout>
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <!-- Kategoriler -->
      <div class="md:col-span-1 space-y-4">
        <div class="bg-gray-800 rounded-lg p-4">
          <h3 class="text-lg font-semibold text-white mb-4">Categories</h3>
          <div class="space-y-2">
            <button
              v-for="category in categories"
              :key="category.id"
              @click="selectedCategory = category"
              class="w-full text-left px-4 py-2 rounded-lg transition"
              :class="{
                'bg-blue-600 text-white': selectedCategory?.id === category.id,
                'text-gray-300 hover:bg-gray-700': selectedCategory?.id !== category.id
              }"
            >
              {{ category.name }}
            </button>
          </div>
        </div>

        <!-- EPG -->
        <div class="bg-gray-800 rounded-lg p-4">
          <h3 class="text-lg font-semibold text-white mb-4">Now Playing</h3>
          <div class="space-y-4">
            <div v-for="program in currentPrograms" :key="program.id" class="text-gray-300">
              <h4 class="font-medium">{{ program.channel }}</h4>
              <p class="text-sm">{{ program.title }}</p>
              <div class="w-full bg-gray-700 rounded-full h-2 mt-2">
                <div
                  class="bg-blue-600 h-2 rounded-full"
                  :style="{ width: program.progress + '%' }"
                ></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- İçerik Listesi -->
      <div class="md:col-span-2 lg:col-span-3">
        <!-- Tabs -->
        <div class="bg-gray-800 rounded-lg p-4 mb-6">
          <div class="flex space-x-4">
            <button
              v-for="tab in tabs"
              :key="tab.id"
              @click="currentTab = tab.id"
              class="px-4 py-2 rounded-lg transition"
              :class="{
                'bg-blue-600 text-white': currentTab === tab.id,
                'text-gray-300 hover:bg-gray-700': currentTab !== tab.id
              }"
            >
              {{ tab.name }}
            </button>
          </div>
        </div>

        <!-- Live TV -->
        <div v-if="currentTab === 'live'" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
          <div
            v-for="channel in filteredChannels"
            :key="channel.id"
            class="bg-gray-800 rounded-lg overflow-hidden group cursor-pointer"
            @click="playChannel(channel)"
          >
            <div class="aspect-video relative">
              <img :src="channel.logo" :alt="channel.name" class="w-full h-full object-cover">
              <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition flex items-center justify-center">
                <i class="fas fa-play text-white text-3xl opacity-0 group-hover:opacity-100 transition"></i>
              </div>
            </div>
            <div class="p-4">
              <h3 class="text-white font-medium">{{ channel.name }}</h3>
              <p v-if="channel.currentProgram" class="text-sm text-gray-400 mt-1">
                {{ channel.currentProgram }}
              </p>
            </div>
          </div>
        </div>

        <!-- Movies -->
        <div v-if="currentTab === 'movies'" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
          <div
            v-for="movie in filteredMovies"
            :key="movie.id"
            class="bg-gray-800 rounded-lg overflow-hidden group cursor-pointer"
            @click="playMovie(movie)"
          >
            <div class="aspect-[2/3] relative">
              <img :src="movie.poster" :alt="movie.name" class="w-full h-full object-cover">
              <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition flex items-center justify-center">
                <i class="fas fa-play text-white text-3xl opacity-0 group-hover:opacity-100 transition"></i>
              </div>
            </div>
            <div class="p-4">
              <h3 class="text-white font-medium">{{ movie.name }}</h3>
              <div class="flex items-center mt-2">
                <span class="text-yellow-400 text-sm">★ {{ movie.rating }}</span>
                <span class="text-gray-400 text-sm ml-2">{{ movie.year }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Series -->
        <div v-if="currentTab === 'series'" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
          <div
            v-for="series in filteredSeries"
            :key="series.id"
            class="bg-gray-800 rounded-lg overflow-hidden group cursor-pointer"
            @click="viewSeries(series)"
          >
            <div class="aspect-[2/3] relative">
              <img :src="series.poster" :alt="series.name" class="w-full h-full object-cover">
              <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition flex items-center justify-center">
                <i class="fas fa-info text-white text-3xl opacity-0 group-hover:opacity-100 transition"></i>
              </div>
            </div>
            <div class="p-4">
              <h3 class="text-white font-medium">{{ series.name }}</h3>
              <div class="flex items-center mt-2">
                <span class="text-yellow-400 text-sm">★ {{ series.rating }}</span>
                <span class="text-gray-400 text-sm ml-2">{{ series.seasons }} seasons</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Video Player Modal -->
    <Modal v-if="showPlayer" @close="showPlayer = false">
      <div class="aspect-video">
        <video-player
          :src="currentStream"
          :type="currentStreamType"
          class="w-full h-full"
          controls
          autoplay
        />
      </div>
    </Modal>

    <!-- Series Info Modal -->
    <Modal v-if="showSeriesInfo" @close="showSeriesInfo = false">
      <div class="p-6">
        <div class="flex space-x-6">
          <img :src="selectedSeries?.poster" :alt="selectedSeries?.name" class="w-48 rounded-lg">
          <div>
            <h2 class="text-2xl font-bold text-white">{{ selectedSeries?.name }}</h2>
            <p class="text-gray-400 mt-2">{{ selectedSeries?.description }}</p>
            <div class="flex items-center mt-4">
              <span class="text-yellow-400">★ {{ selectedSeries?.rating }}</span>
              <span class="text-gray-400 mx-2">|</span>
              <span class="text-gray-400">{{ selectedSeries?.genre }}</span>
            </div>
          </div>
        </div>

        <div class="mt-8">
          <h3 class="text-lg font-semibold text-white mb-4">Episodes</h3>
          <div class="space-y-4">
            <div v-for="season in selectedSeries?.seasons" :key="season.number">
              <h4 class="text-white font-medium mb-2">Season {{ season.number }}</h4>
              <div class="grid grid-cols-2 gap-4">
                <div
                  v-for="episode in season.episodes"
                  :key="episode.id"
                  class="bg-gray-800 p-4 rounded-lg cursor-pointer hover:bg-gray-700"
                  @click="playEpisode(episode)"
                >
                  <h5 class="text-white">{{ episode.number }}. {{ episode.name }}</h5>
                  <p class="text-sm text-gray-400 mt-1">{{ episode.duration }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Modal>
  </ClientLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import ClientLayout from '@/Layouts/ClientLayout.vue'
import Modal from '@/Components/Modal.vue'
import VideoPlayer from '@/Components/VideoPlayer.vue'

const props = defineProps({
  categories: Array,
  channels: Array,
  movies: Array,
  series: Array,
  currentPrograms: Array,
})

const tabs = [
  { id: 'live', name: 'Live TV' },
  { id: 'movies', name: 'Movies' },
  { id: 'series', name: 'Series' },
]

const currentTab = ref('live')
const selectedCategory = ref(null)
const showPlayer = ref(false)
const showSeriesInfo = ref(false)
const currentStream = ref(null)
const currentStreamType = ref(null)
const selectedSeries = ref(null)

const filteredChannels = computed(() => {
  if (!selectedCategory.value) return props.channels
  return props.channels.filter(c => c.category_id === selectedCategory.value.id)
})

const filteredMovies = computed(() => {
  if (!selectedCategory.value) return props.movies
  return props.movies.filter(m => m.category_id === selectedCategory.value.id)
})

const filteredSeries = computed(() => {
  if (!selectedCategory.value) return props.series
  return props.series.filter(s => s.category_id === selectedCategory.value.id)
})

const playChannel = (channel) => {
  currentStream.value = channel.stream_url
  currentStreamType.value = 'application/x-mpegURL'
  showPlayer.value = true
}

const playMovie = (movie) => {
  currentStream.value = movie.stream_url
  currentStreamType.value = 'application/x-mpegURL'
  showPlayer.value = true
}

const viewSeries = (series) => {
  selectedSeries.value = series
  showSeriesInfo.value = true
}

const playEpisode = (episode) => {
  currentStream.value = episode.stream_url
  currentStreamType.value = 'application/x-mpegURL'
  showSeriesInfo.value = false
  showPlayer.value = true
}
</script>