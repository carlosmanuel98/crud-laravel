export const taskStatuses = ['pendiente', 'en_progreso', 'completada']

const taskStatusConfig = {
  pendiente: {
    label: 'Pendiente',
    className: 'text-bg-warning',
  },
  en_progreso: {
    label: 'En progreso',
    className: 'text-bg-info',
  },
  completada: {
    label: 'Completada',
    className: 'text-bg-success',
  },
}

const taskPriorityConfig = {
  BAJA: {
    label: 'Baja',
    className: 'text-secondary',
  },
  MEDIA: {
    label: 'Media',
    className: 'text-warning-emphasis',
  },
  ALTA: {
    label: 'Alta',
    className: 'text-danger',
  },
}

export function formatTaskStatus(status) {
  return taskStatusConfig[status]?.label ?? status
}

export function getTaskStatusClass(status) {
  return taskStatusConfig[status]?.className ?? 'text-bg-secondary'
}

export function formatTaskPriority(priority) {
  return taskPriorityConfig[priority]?.label ?? priority
}

export function getTaskPriorityClass(priority) {
  return taskPriorityConfig[priority]?.className ?? 'text-secondary'
}
