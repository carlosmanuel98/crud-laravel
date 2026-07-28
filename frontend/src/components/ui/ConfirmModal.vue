<script setup>
defineProps({
  show: {
    type: Boolean,
    default: false,
  },
  title: {
    type: String,
    default: 'Confirmar eliminación',
  },
  message: {
    type: String,
    default: '¿Seguro que quieres eliminar este elemento?',
  },
  onClose: {
    type: Function,
    default: () => {},
  },
  onConfirm: {
    type: Function,
    default: () => {},
  },
})
</script>

<template>
  <div v-if="show">
    <div class="modal fade show d-block" tabindex="-1" role="dialog" aria-modal="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
          <div class="modal-header">
            <h5 class="modal-title">{{ title }}</h5>
            <button type="button" class="btn-close" aria-label="Close" @click="onClose()"></button>
          </div>

          <div class="modal-body">
            <p class="mb-0 text-secondary">{{ message }}</p>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-light border" @click="onClose()">
              Cancelar
            </button>
            <button type="button" class="btn btn-danger" @click="onConfirm()">
              Eliminar
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal-backdrop fade show"></div>
  </div>
</template>
