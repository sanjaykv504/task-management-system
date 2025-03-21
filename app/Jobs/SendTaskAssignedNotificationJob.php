<?php

namespace App\Jobs;

use App\Mail\TaskNotificationMail;
use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendTaskAssignedNotificationJob implements ShouldQueue
{
    use InteractsWithQueue,Queueable,SerializesModels;

    protected $task;
    /**
     * Create a new job instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->task->assigned_to) {
            $user = $this->task->assignedUser;
            Mail::to($user->email)->send(new TaskNotificationMail($this->task));
        }
    }
}
