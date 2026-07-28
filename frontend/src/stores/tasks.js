import { computed, ref } from 'vue'
import { defineStore } from 'pinia'
import api from '../services/api'
import { taskStatuses } from '../helpers/task'
import { useToastStore } from './toast'

export const useTasksStore = defineStore('tasks', () => {
  const toast = useToastStore()
  const tasks = ref([])
  const priorities = ref([])
  const tags = ref([])
  const selectedTask = ref(null)
  const loading = ref(false)
  const error = ref('')
  const formErrors = ref({})
  const filters = ref({
    search: '',
    estado: '',
    fecha_vencimiento: '',
  })

  // Filter
  const filteredTasks = computed(() => {
    return tasks.value.filter((task) => {
      const matchesSearch = !filters.value.search || task.titulo.toLowerCase().includes(filters.value.search.toLowerCase())
      const matchesStatus = !filters.value.estado || task.estado === filters.value.estado
      const matchesDate = !filters.value.fecha_vencimiento || task.fecha_vencimiento === filters.value.fecha_vencimiento

      return matchesSearch && matchesStatus && matchesDate
    })
  })

  async function loadCatalogs() {
    const [prioritiesResponse, tagsResponse] = await Promise.all([
      api.get('/priorities'),
      api.get('/tags'),
    ])

    priorities.value = prioritiesResponse.data.data
    tags.value = tagsResponse.data.data
  }

  async function loadTasks() {
    loading.value = true
    error.value = ''

    try {
      const response = await api.get('/tasks')
      tasks.value = response.data.data
    } catch (loadError) {
      error.value = 'No se pudieron cargar las tareas.'
      console.error(loadError)
    } finally {
      loading.value = false
    }
  }

  function selectTask(task) {
    selectedTask.value = task
    formErrors.value = {}
  }

  function clearSelectedTask() {
    selectedTask.value = null
    formErrors.value = {}
  }

  function clearFilters() {
    filters.value = {
      search: '',
      estado: '',
      fecha_vencimiento: '',
    }
  }

  // CRUD
  async function createTask(data = {}) {
    formErrors.value = {}
    error.value = ''

    try {
      const response = await api.post('/tasks', data)
      await loadTasks()
      toast.showToast('Tarea creada correctamente.')
      return response.data.data
    } catch (requestError) {
      if (requestError.response?.status === 422) {
        formErrors.value = requestError.response.data.errors ?? {}
      } else {
        error.value = 'No se pudo guardar la tarea.'
        toast.showToast('No se pudo guardar la tarea.', 'error')
      }
      console.error(requestError)
      return null
    }
  }

  async function updateTask(taskId, data = {}) {
    formErrors.value = {}
    error.value = ''

    try {
      const response = await api.put(`/tasks/${taskId}`, data)
      await loadTasks()
      selectedTask.value = response.data.data
      toast.showToast('Tarea actualizada correctamente.')
      return response.data.data
    } catch (requestError) {
      if (requestError.response?.status === 422) {
        formErrors.value = requestError.response.data.errors ?? {}
      } else {
        error.value = 'No se pudo actualizar la tarea.'
        toast.showToast('No se pudo actualizar la tarea.', 'error')
      }
      console.error(requestError)
      return null
    }
  }

  async function deleteTask(taskId) {
    error.value = ''

    try {
      await api.delete(`/tasks/${taskId}`)
      await loadTasks()
      toast.showToast('Tarea eliminada correctamente.')

      if (selectedTask.value?.id === taskId) {
        selectedTask.value = null
      }
    } catch (requestError) {
      error.value = 'No se pudo eliminar la tarea.'
      toast.showToast('No se pudo eliminar la tarea.', 'error')
      console.error(requestError)
    }
  }

  return {
    tasks,
    priorities,
    tags,
    taskStatuses,
    selectedTask,
    loading,
    error,
    formErrors,
    filters,
    filteredTasks,
    loadCatalogs,
    loadTasks,
    selectTask,
    clearSelectedTask,
    clearFilters,
    createTask,
    updateTask,
    deleteTask,
  }
})
