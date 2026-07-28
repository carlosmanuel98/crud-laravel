<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\DB;

class TaskService
{
    public function getAll()
    {
        return Task::with(['priority', 'tags'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function create(array $data, $tags = [])
    {
        DB::beginTransaction();

        try {
            $task = Task::create($data);
            $task->tags()->sync($tags);

            DB::commit();

            return $task;
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function update(Task $task, array $data, $tags = null)
    {
        DB::beginTransaction();

        try {
            $task->update($data);

            if ($tags !== null) {
                $task->tags()->sync($tags);
            }

            DB::commit();

            return $task;
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function delete(Task $task)
    {
        DB::beginTransaction();

        try {
            $task->delete();

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
