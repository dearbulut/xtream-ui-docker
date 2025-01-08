<template>
  <div class="relative">
    <video
      ref="videoRef"
      class="w-full"
      :controls="controls"
      :autoplay="autoplay"
      @play="onPlay"
      @pause="onPause"
      @timeupdate="onTimeUpdate"
      @ended="onEnded"
    ></video>

    <!-- Custom Controls -->
    <div v-if="!controls" class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
      <div class="flex items-center space-x-4">
        <button @click="togglePlay" class="text-white">
          <i :class="['fas', isPlaying ? 'fa-pause' : 'fa-play']"></i>
        </button>

        <!-- Progress Bar -->
        <div class="flex-1">
          <div class="h-1 bg-gray-600 rounded-full">
            <div
              class="h-full bg-blue-500 rounded-full"
              :style="{ width: progress + '%' }"
            ></div>
          </div>
        </div>

        <!-- Volume -->
        <div class="relative">
          <button @click="toggleMute" class="text-white">
            <i :class="['fas', isMuted ? 'fa-volume-mute' : 'fa-volume-up']"></i>
          </button>
          <input
            type="range"
            min="0"
            max="100"
            v-model="volume"
            class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 w-24"
          >
        </div>

        <!-- Fullscreen -->
        <button @click="toggleFullscreen" class="text-white">
          <i :class="['fas', isFullscreen ? 'fa-compress' : 'fa-expand']"></i>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import Hls from 'hls.js'

const props = defineProps({
  src: String,
  type: String,
  controls: {
    type: Boolean,
    default: true
  },
  autoplay: {
    type: Boolean,
    default: false
  }
})

const videoRef = ref(null)
const isPlaying = ref(false)
const isMuted = ref(false)
const volume = ref(100)
const progress = ref(0)
const isFullscreen = ref(false)
let hls = null

onMounted(() => {
  if (props.type === 'application/x-mpegURL' && Hls.isSupported()) {
    hls = new Hls()
    hls.loadSource(props.src)
    hls.attachMedia(videoRef.value)
  } else {
    videoRef.value.src = props.src
  }
})

watch(() => props.src, (newSrc) => {
  if (hls) {
    hls.destroy()
    hls = new Hls()
    hls.loadSource(newSrc)
    hls.attachMedia(videoRef.value)
  } else {
    videoRef.value.src = newSrc
  }
})

const togglePlay = () => {
  if (videoRef.value.paused) {
    videoRef.value.play()
  } else {
    videoRef.value.pause()
  }
}

const toggleMute = () => {
  videoRef.value.muted = !videoRef.value.muted
  isMuted.value = videoRef.value.muted
}

const toggleFullscreen = () => {
  if (!document.fullscreenElement) {
    videoRef.value.requestFullscreen()
  } else {
    document.exitFullscreen()
  }
}

const onPlay = () => {
  isPlaying.value = true
}

const onPause = () => {
  isPlaying.value = false
}

const onTimeUpdate = () => {
  const video = videoRef.value
  progress.value = (video.currentTime / video.duration) * 100
}

const onEnded = () => {
  isPlaying.value = false
  progress.value = 0
}

watch(volume, (newVolume) => {
  videoRef.value.volume = newVolume / 100
})
</script>