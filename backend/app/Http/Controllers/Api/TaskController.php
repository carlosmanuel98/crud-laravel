<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Services\TaskService;

class TaskController extends Controller
{
    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {
        $tasks = $this->taskService->getAll();

        return response()->json([
            'success' => true,
            'data' => $tasks,
        ]);
    }

    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();
        $tags = $request->input('tags', []);

        $task = $this->taskService->create($data, $tags);

        return response()->json([
            'success' => true,
            'data' => $task,
        ], 201);
    }

    public function show(int $taskId)
    {
        $task = Task::findOrFail($taskId);

        return response()->json([
            'success' => true,
            'data' => $task,
        ]);
    }

    public function update(UpdateTaskRequest $request, int $taskId)
    {
        $task = Task::findOrFail($taskId);
        $data = $request->validated();
        $tags = $request->input('tags', null);

        $task = $this->taskService->update($task, $data, $tags);

        return response()->json([
            'success' => true,
            'data' => $task,
        ]);
    }

    public function destroy(int $taskId)
    {
        $task = Task::findOrFail($taskId);
        $this->taskService->delete($task);

        return response()->json([
            'success' => true,
            'message' => 'Tarea eliminada correctamente.',
        ]);
    }
}
