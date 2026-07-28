import { ref } from 'vue'
import { defineStore } from 'pinia'

export const useToastStore = defineStore('toast', () => {
  const toast = ref(null)
  let toastTimeout = null

  function showToast(message, type = 'success') {
    toast.value = {
      message,
      type,
    }

    if (toastTimeout) {
      clearTimeout(toastTimeout)
    }

    toastTimeout = setTimeout(() => {
      toast.value = null
    }, 2500)
  }

  function clearToast() {
    toast.value = null

    if (toastTimeout) {
      clearTimeout(toastTimeout)
      toastTimeout = null
    }
  }

  return {
    toast,
    showToast,
    clearToast,
  }
})
