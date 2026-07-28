<script setup>
import { useToastStore } from '../../stores/toast'

defineProps({
  toast: {
    type: Object,
    default: null,
  },
})

const toastStore = useToastStore()
</script>

<template>
  <div v-if="toast" class="toast-container position-fixed top-0 end-0 p-3">
    <div class="toast show border-0 shadow-sm" :class="toast.type === 'error' ? 'text-bg-danger' : 'text-bg-success'">
      <div class="d-flex align-items-center">
        <div class="toast-body fw-semibold">
          {{ toast.message }}
        </div>
        <button
          type="button"
          class="btn-close btn-close-white me-2 m-auto"
          aria-label="Close"
          @click="toastStore.clearToast()"
        ></button>
      </div>
    </div>
  </div>
</template>
