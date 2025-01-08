import { ref } from 'vue'

const toasts = ref([])

export function useToast() {
  const showToast = ({ type = 'success', message, duration = 5000 }) => {
    const id = Date.now()
    toasts.value.push({ id, type, message })

    setTimeout(() => {
      removeToast(id)
    }, duration)
  }

  const removeToast = (id) => {
    const index = toasts.value.findIndex((toast) => toast.id === id)
    if (index > -1) {
      toasts.value.splice(index, 1)
    }
  }

  return {
    toasts,
    showToast,
    removeToast,
  }
}