<script setup>
import { onMounted } from 'vue'
import { storeToRefs } from 'pinia'
import TaskFilters from '../components/tasks/TaskFilters.vue'
import TaskForm from '../components/tasks/TaskForm.vue'
import TaskList from '../components/tasks/TaskList.vue'
import { useTasksStore } from '../stores/tasks'

const tasksStore = useTasksStore()
const { filteredTasks, priorities, tags, loading, error } = storeToRefs(tasksStore)

onMounted(() => {
  Promise.all([
    tasksStore.loadCatalogs(),
    tasksStore.loadTasks(),
  ])
})
</script>

<template>
  <main class="container py-4 py-lg-5">
    <section class="mb-4">
      <p class="text-uppercase fw-bold text-secondary small mb-2">Desafío técnico</p>
      <h1 class="display-4 fw-bold mb-3">Gestión de tareas</h1>
      <p class="lead mb-0">
        Gestiona tareas con estado, prioridad, fecha de vencimiento y etiquetas desde una sola interfaz.
      </p>
    </section>

    <div v-if="loading" class="alert alert-light border shadow-sm" role="status">Cargando datos...</div>
    <div v-else-if="error" class="alert alert-danger shadow-sm" role="alert">{{ error }}</div>

    <section v-else class="row g-4 align-items-start">
      <div class="col-12 col-xl-8 d-grid gap-4">
        <TaskFilters />
        <TaskList :filtered-tasks="filteredTasks" />
      </div>

      <aside class="col-12 col-xl-4">
        <TaskForm :priorities="priorities" :tags="tags" />
      </aside>
    </section>
  </main>
</template>
