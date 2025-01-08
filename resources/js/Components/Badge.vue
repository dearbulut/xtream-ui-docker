<template>
  <span
    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
    :class="{
      'bg-gray-100 text-gray-800': color === 'gray',
      'bg-red-100 text-red-800': color === 'danger',
      'bg-yellow-100 text-yellow-800': color === 'warning',
      'bg-green-100 text-green-800': color === 'success',
      'bg-blue-100 text-blue-800': color === 'info',
      'bg-indigo-100 text-indigo-800': color === 'primary',
      'bg-purple-100 text-purple-800': color === 'purple',
      'bg-pink-100 text-pink-800': color === 'pink',
    }"
  >
    <slot />
  </span>
</template>

<script setup>
defineProps({
  color: {
    type: String,
    default: 'gray',
    validator: (value) =>
      ['gray', 'danger', 'warning', 'success', 'info', 'primary', 'purple', 'pink'].includes(value),
  },
})
</script>