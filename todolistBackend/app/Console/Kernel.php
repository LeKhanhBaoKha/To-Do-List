<?php

namespace App\Console;

use App\Models\Todo;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
       $schedule->call(function (){
        $todos = Todo::all();

        foreach ($todos as $todo) {
            $deadline = Carbon::parse($todo->deadline);
            $now = Carbon::now();

            if ($now->gt($deadline)) {
                $timeLeft = 0;
            } else {
                $timeLeft = $now->diffInMinutes($deadline);
            }
            // Update the timeLeft for the current todo
            $todo->update(['timeLeft' => $timeLeft]);
        }
       })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
