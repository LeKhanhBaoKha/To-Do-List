<?php

namespace App\Listeners;

use App\Events\TaskReminderEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTaskReminderNotification
{
    /**
     * Create the event listener.
     */
    use InteractsWithQueue;
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TaskReminderEvent $event): void
    {
        //
    }
}
