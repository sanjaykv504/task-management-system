<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\TaskAssignRequest;
use App\Http\Requests\Tasks\TaskStoreRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }


    // Create a new task
    public function storeTask(TaskStoreRequest $request)
    {
        $data = $request->validated();
        $task = $this->taskService->createTask($data);
        return $this->responseData("Task Created",new TaskResource($task));
    }

    // Assign a task
    public function assignTask(TaskAssignRequest $request, $id)
    {
        $data = $request->validated();
        $task = $this->taskService->assignTask($id, $data['assigned_to']);
        return $this->responseData("Task Assigned",new TaskResource($task));
    }

    // Mark a task as completed one
    public function completeTask($id)
    {
        $task = $this->taskService->completeTask($id);
        return $this->responseData("Task Completed",new TaskResource($task));
    }

    // List tasks with filters
    public function showTasks(Request $request)
    {
        $query = Task::query();
        if ($request->has('status')) {
            $query->where('status', $request->query('status'));
        }
        if ($request->has('assigned_to')) {
            $query->where('assigned_to', $request->query('assigned_to'));
        }
        $tasks = $query->paginate(10);
        return $this->responseData("Tasks List",TaskResource::collection($tasks)); 
    }

}
