<script setup>
import { computed, reactive, watch } from 'vue'
import { storeToRefs } from 'pinia'
import { useTasksStore } from '../../stores/tasks'
import { formatTaskStatus, taskStatuses } from '../../helpers/task'

defineProps({
  priorities: {
    type: Array,
    default: () => [],
  },
  tags: {
    type: Array,
    default: () => [],
  },
})

const tasksStore = useTasksStore()
const { formErrors, selectedTask } = storeToRefs(tasksStore)

const form = reactive({
  titulo: '',
  descripcion: '',
  estado: 'pendiente',
  fecha_vencimiento: '',
  prioridad_id: '',
  tags: [],
})

// Indica si el formulario esta en modo edicion
const editMode = computed(() => Boolean(selectedTask.value))

function resetForm() {
  form.titulo = ''
  form.descripcion = ''
  form.estado = 'pendiente'
  form.fecha_vencimiento = ''
  form.prioridad_id = ''
  form.tags = []
}

watch(selectedTask, (task) => {
  // console.log("task", task)
    if (!task) {
      resetForm()
      return
    }

    form.titulo = task.titulo ?? ''
    form.descripcion = task.descripcion ?? ''
    form.estado = task.estado ?? 'pendiente'
    form.fecha_vencimiento = task.fecha_vencimiento ?? ''
    form.prioridad_id = task.prioridad_id ?? task.priority?.id ?? ''
    form.tags = task.tags?.map((tag) => tag.id) ?? []
})

async function submitForm() {
  const data = {
    titulo: form.titulo,
    descripcion: form.descripcion,
    estado: form.estado,
    prioridad_id: form.prioridad_id,
    tags: form.tags,
    fecha_vencimiento: form.fecha_vencimiento || null,
  }

  let result = null

  if (editMode.value) {
    result = await tasksStore.updateTask(selectedTask.value.id, data)
  } else {
    result = await tasksStore.createTask(data)
  }

  if (result) {
    resetForm()
    tasksStore.clearSelectedTask()
  }
}
</script>

<template>
  <section class="card border-0 shadow-sm position-sticky" style="top: 24px">
    <div class="card-body p-4">
      <p class="text-uppercase fw-bold text-secondary small mb-1">Formulario</p>
      <div class="d-flex justify-content-between align-items-start gap-3 mb-2">
        <h2 class="h2 mb-0">{{ editMode ? 'Editar tarea' : 'Nueva tarea' }}</h2>
        <button
          v-if="editMode"
          type="button"
          class="btn btn-sm btn-light border fw-semibold px-3"
          @click="tasksStore.clearSelectedTask()"
        >
          Cancelar
        </button>
      </div>
      <p class="text-secondary mb-4">
        {{ editMode ? 
        'Actualiza los datos de la tarea seleccionada desde este panel.' : 
        'Usa este panel para crear una tarea nueva y asignarle prioridad, estado y una o varias etiquetas.' 
        }}
      </p>

      <form class="d-grid gap-3" @submit.prevent="submitForm">
        <div>
          <label class="form-label fw-semibold">Título</label>
          <input v-model="form.titulo" type="text" class="form-control" placeholder="Ej. Preparar demo" />
          <div v-if="formErrors.titulo" class="text-danger small mt-1">{{ formErrors.titulo[0] }}</div>
        </div>

        <div>
          <label class="form-label fw-semibold">Descripción</label>
          <textarea
            v-model="form.descripcion"
            rows="4"
            class="form-control"
            placeholder="Describe la tarea"
          ></textarea>
          <div v-if="formErrors.descripcion" class="text-danger small mt-1">
            {{ formErrors.descripcion[0] }}
          </div>
        </div>

        <div>
          <label class="form-label fw-semibold">Estado</label>
          <select v-model="form.estado" class="form-select">
            <option v-for="status in taskStatuses" :key="status" :value="status">
              {{ formatTaskStatus(status) }}
            </option>
          </select>
          <div v-if="formErrors.estado" class="text-danger small mt-1">{{ formErrors.estado[0] }}</div>
        </div>

        <div>
          <label class="form-label fw-semibold">Prioridad</label>
          <select v-model="form.prioridad_id" class="form-select">
            <option value="">Selecciona una prioridad</option>
            <option v-for="priority in priorities" :key="priority.id" :value="priority.id">
              {{ priority.prioridad }}
            </option>
          </select>
          <div v-if="formErrors.prioridad_id" class="text-danger small mt-1">
            {{ formErrors.prioridad_id[0] }}
          </div>
        </div>

        <div>
          <label class="form-label fw-semibold">Fecha de vencimiento</label>
          <input v-model="form.fecha_vencimiento" type="date" class="form-control" />
          <div v-if="formErrors.fecha_vencimiento" class="text-danger small mt-1">
            {{ formErrors.fecha_vencimiento[0] }}
          </div>
        </div>

        <fieldset class="border-0 p-0 m-0">
          <legend class="fs-4 fw-bold mb-3">Etiquetas</legend>

          <div class="d-grid gap-2">
            <label
              v-for="tag in tags"
              :key="tag.id"
              class="d-flex align-items-center gap-2 p-3 border rounded-4 bg-white"
            >
              <input
                v-model="form.tags"
                type="checkbox"
                class="form-check-input m-0"
                :value="tag.id"
              />
              <span class="fw-semibold">{{ tag.etiqueta }}</span>
            </label>
          </div>
          <div v-if="formErrors.tags" class="text-danger small mt-2">{{ formErrors.tags[0] }}</div>
        </fieldset>

        <button type="submit" class="btn btn-dark btn-lg">
          {{ editMode ? 'Actualizar tarea' : 'Guardar tarea' }}
        </button>
      </form>
    </div>
  </section>
</template>
