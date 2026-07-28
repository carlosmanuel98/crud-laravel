<script setup>
import { computed, ref } from 'vue'
import { storeToRefs } from 'pinia'
import { useTasksStore } from '../../stores/tasks'
import ConfirmModal from '../ui/ConfirmModal.vue'
import { formatDate } from '../../helpers/date'
import {
  formatTaskPriority,
  formatTaskStatus,
  getTaskPriorityClass,
  getTaskStatusClass,
} from '../../helpers/task'

const { filteredTasks } = defineProps({
  filteredTasks: {
    type: Array,
    default: () => [],
  },
})

const tasksStore = useTasksStore()
const { filters } = storeToRefs(tasksStore)
const taskToConfirm = ref(null)

const filtersActive = computed(() => {
  return filters.value.search || filters.value.estado || filters.value.fecha_vencimiento
})

function openConfirmModal(task) {
  // console.log(task)
  taskToConfirm.value = task
}

function closeConfirmModal() {
  taskToConfirm.value = null
}

async function confirmDeleteTask() {
  if (!taskToConfirm.value) {
    return
  }

  await tasksStore.deleteTask(taskToConfirm.value.id)
  closeConfirmModal()
}
</script>

<template>
  <section class="card border-0 shadow-sm">
    <div class="card-body p-4">
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-start gap-3 mb-4">
        <div>
          <p class="text-uppercase fw-bold text-secondary small mb-1">Listado</p>
          <h2 class="mb-1">Tareas</h2>
          <p class="text-secondary mb-0">Desde aquí podrás editar o eliminar cada tarea creada.</p>
        </div>
        <p class="fs-1 fw-bold mb-0">{{ filteredTasks.length }}</p>
      </div>

      <ul v-if="filteredTasks.length" class="list-unstyled d-grid gap-3 mb-0">
        <li
          v-for="task in filteredTasks"
          :key="task.id"
          class="rounded-4 border bg-body-tertiary-subtle p-4 d-flex flex-column flex-lg-row justify-content-between gap-4"
        >
          <div class="flex-grow-1">
            <div class="d-flex flex-wrap align-items-center gap-3 mb-2">
              <h3 class="h4 mb-0">{{ task.titulo }}</h3>
              <span class="badge rounded-pill" :class="getTaskStatusClass(task.estado)">
                {{ formatTaskStatus(task.estado) }}
              </span>
            </div>

            <p class="text-secondary mb-3">{{ task.descripcion }}</p>

            <div class="d-flex flex-wrap gap-2">
              <button
                type="button"
                class="btn btn-sm btn-dark px-2 py-1"
                @click="tasksStore.selectTask(task)"
              >
                Editar
              </button>
              <button
                type="button"
                class="btn btn-sm btn-outline-danger px-2 py-1"
                @click="openConfirmModal(task)"
              >
                Eliminar
              </button>
            </div>
          </div>

          <div class="d-flex flex-column gap-3 text-lg-end pt-1">
            <div>
              <p class="text-secondary small fw-semibold mb-1">Prioridad</p>
              <span
                v-if="task.priority"
                class="d-inline-flex align-items-center gap-2 small fw-semibold"
                :class="getTaskPriorityClass(task.priority.prioridad)"
              >
                <span class="rounded-circle bg-current d-inline-block" style="width: 10px; height: 10px"></span>
                {{ formatTaskPriority(task.priority.prioridad) }}
              </span>
              <span v-else class="text-secondary small">Sin prioridad</span>
            </div>

            <div>
              <p class="text-secondary small fw-semibold mb-1">Vencimiento</p>
              <span v-if="task.fecha_vencimiento" class="text-secondary small fw-semibold">
                {{ formatDate(task.fecha_vencimiento) }}
              </span>
              <span v-else class="text-secondary small">Sin fecha</span>
            </div>

            <div v-if="task.tags?.length">
              <p class="text-secondary small fw-semibold mb-2">Etiquetas</p>
              <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                <span
                  v-for="tag in task.tags"
                  :key="tag.id"
                  class="badge rounded-pill text-bg-light border text-dark"
                >
                  {{ tag.etiqueta }}
                </span>
              </div>
            </div>
          </div>
        </li>
      </ul>

      <div v-else class="rounded-4 border bg-body-tertiary-subtle p-4 text-center">
        <h3 class="h5 mb-2">
          {{ filtersActive ? 'No se encontraron tareas' : 'Todavía no hay tareas creadas' }}
        </h3>
        <p class="text-secondary mb-0">
          {{ filtersActive ? 'Prueba limpiando o ajustando los filtros de búsqueda.' : 'Completa el formulario de la derecha para registrar la primera.' }}
        </p>
      </div>
    </div>

    <ConfirmModal
      :show="Boolean(taskToConfirm)"
      title="Eliminar tarea"
      :message="taskToConfirm ? `¿Seguro que quieres eliminar la tarea ${taskToConfirm.titulo}?` : ''"
      :on-close="closeConfirmModal"
      :on-confirm="confirmDeleteTask"
    />
  </section>
</template>
