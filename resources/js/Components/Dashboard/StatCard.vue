<template>
  <div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-lg font-semibold">{{ title }}</h3>
      <div :class="[`text-${color}-500`]">
        <i :class="['fas', `fa-${icon}`]"></i>
      </div>
    </div>
    <div class="text-3xl font-bold mb-4">{{ value }}</div>
    <slot name="footer"></slot>
  </div>
</template>

<script setup>
defineProps({
  title: String,
  value: [String, Number],
  icon: String,
  color: {
    type: String,
    default: 'blue'
  }
})
</script>