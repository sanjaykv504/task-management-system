<?php

namespace App\Services;

use App\Events\TaskCompleteEvent;
use App\Jobs\SendTaskAssignedNotificationJob;
use App\Models\Task;
use Carbon\Carbon;

class TaskService
{
    public $model;

    public function __construct(Task $model) 
    {
        $this->model = $model;
    }
    public function createTask(array $data): Task
    {
        return $this->model::create($data);
    }

    public function assignTask($taskId, int $userId): Task
    {
        $task = $this->model::findOrFail($taskId);
        $task->update(['assigned_to' => $userId]);
        SendTaskAssignedNotificationJob::dispatch($task);
        return $task;
    }

    public function completeTask(int $taskId): Task
    {
        $task = $this->model::findOrFail($taskId);
        $task->update(['status' => 'completed']);
        event(new TaskCompleteEvent($task));
        return $task;
    }

    public function expireOverdueTasks()
    {
        $now = Carbon::now();
        $this->model::where('due_date', '<', $now)
            ->where('status', 'pending')
            ->update(['status' => 'expired']);
    }
}
