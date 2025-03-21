<?php

namespace App\Console\Commands;

use App\Services\TaskService;
use Illuminate\Console\Command;

class OverDueTasks extends Command
{
    protected $taskService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:over-due-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark overdue pending tasks as expired';

    public function __construct(TaskService $taskService)
    {
        parent::__construct();
        $this->taskService = $taskService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->taskService->expireOverdueTasks();
        info('Overdue tasks marked as expired.');
    }
}
