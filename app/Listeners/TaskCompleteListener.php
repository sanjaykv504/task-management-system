<?php

namespace App\Listeners;

use App\Events\TaskCompleteEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class TaskCompleteListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TaskCompleteEvent $event): void
    {
        Log::info("Task [{$event->task->title}] has been completed.");
    }
}
