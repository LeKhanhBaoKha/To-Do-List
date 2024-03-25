<?php

namespace App\Console\Commands;

use App\Models\Todo;
use App\Notifications\TaskDeadLineApproaching;
use Illuminate\Console\Command;

class CheckDeadLines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deadlines:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

    }
}
