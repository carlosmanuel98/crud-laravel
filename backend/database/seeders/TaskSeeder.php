<?php

namespace Database\Seeders;

use App\Models\Priority;
use App\Models\Tag;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $prioridadBaja = Priority::where('prioridad', 'BAJA')->first();
        $prioridadMedia = Priority::where('prioridad', 'MEDIA')->first();
        $prioridadAlta = Priority::where('prioridad', 'ALTA')->first();

        $tagDev = Tag::where('etiqueta', 'DEV')->first();
        $tagQa = Tag::where('etiqueta', 'QA')->first();
        $tagRrhh = Tag::where('etiqueta', 'RRHH')->first();

        $taskUno = Task::updateOrCreate(
            ['titulo' => 'Preparar estructura inicial del proyecto'],
            [
                'descripcion' => 'Configurar el entorno base del challenge con backend, frontend y base de datos.',
                'estado' => 'pendiente',
                'fecha_vencimiento' => '2026-07-30',
                'prioridad_id' => $prioridadAlta->id,
            ]
        );
        $taskUno->tags()->sync([$tagDev->id]);

        $taskDos = Task::updateOrCreate(
            ['titulo' => 'Validar formulario de tareas'],
            [
                'descripcion' => 'Revisar que los campos obligatorios, mensajes y reglas funcionen correctamente.',
                'estado' => 'en_progreso',
                'fecha_vencimiento' => '2026-08-01',
                'prioridad_id' => $prioridadMedia->id,
            ]
        );
        $taskDos->tags()->sync([$tagDev->id, $tagQa->id]);

        $taskTres = Task::updateOrCreate(
            ['titulo' => 'Cargar datos de prueba para demo'],
            [
                'descripcion' => 'Registrar tareas base para mostrar el CRUD y los filtros durante la presentación.',
                'estado' => 'completada',
                'fecha_vencimiento' => '2026-07-26',
                'prioridad_id' => $prioridadBaja->id,
            ]
        );
        $taskTres->tags()->sync([$tagQa->id]);

        $taskCuatro = Task::updateOrCreate(
            ['titulo' => 'Coordinar revisión funcional'],
            [
                'descripcion' => 'Dejar lista una tarea de ejemplo vinculada a otra etiqueta del catálogo.',
                'estado' => 'pendiente',
                'fecha_vencimiento' => '2026-08-03',
                'prioridad_id' => $prioridadMedia->id,
            ]
        );
        $taskCuatro->tags()->sync([$tagRrhh->id]);
    }
}
