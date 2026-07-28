<script setup>
import { storeToRefs } from 'pinia'
import { useTasksStore } from '../../stores/tasks'
import { formatTaskStatus, taskStatuses } from '../../helpers/task'

const tasksStore = useTasksStore()
const { filters } = storeToRefs(tasksStore)
</script>

<template>
  <section class="card border-0 shadow-sm">
    <div class="card-body p-4">
      <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-3">
        <div>
          <p class="text-uppercase fw-bold text-secondary small mb-1">Filtros</p>
          <h2 class="h5 mb-0">Buscar tareas</h2>
        </div>

        <button type="button" class="btn btn-sm btn-light border fw-semibold px-3" @click="tasksStore.clearFilters()">
          Limpiar
        </button>
      </div>

      <div class="row g-3">
        <div class="col-12 col-md-4">
          <input
            v-model="filters.search"
            type="text"
            class="form-control"
            placeholder="Buscar por título"
          />
        </div>

        <div class="col-12 col-md-4">
          <select v-model="filters.estado" class="form-select">
            <option value="">Todos los estados</option>
            <option v-for="status in taskStatuses" :key="status" :value="status">
              {{ formatTaskStatus(status) }}
            </option>
          </select>
        </div>

        <div class="col-12 col-md-4">
          <input v-model="filters.fecha_vencimiento" type="date" class="form-control" />
        </div>
      </div>
    </div>
  </section>
</template>
