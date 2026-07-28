<script setup>
import { storeToRefs } from 'pinia'
import ToastMessage from './components/ui/ToastMessage.vue'
import { useToastStore } from './stores/toast'

const toastStore = useToastStore()
const { toast } = storeToRefs(toastStore)
</script>

<template>
  <ToastMessage :toast="toast" />
  <router-view />
</template>

<style>
body {
  margin: 0;
  min-height: 100vh;
  font-family: "Segoe UI", sans-serif;
  background:
    radial-gradient(circle at top left, rgba(244, 215, 184, 0.6), transparent 30%),
    linear-gradient(135deg, #f7f1e8 0%, #e9eef5 100%);
  color: #0f172a;
}

#app {
  min-height: 100vh;
}

* {
  box-sizing: border-box;
}
</style>
