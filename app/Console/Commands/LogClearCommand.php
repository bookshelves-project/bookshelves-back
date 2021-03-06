<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LogClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:clear {name : name of log file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear specific log';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): bool
    {
        $logFileName = $this->argument('name');
        shell_exec("truncate -s 0 ./storage/logs/{$logFileName}.log");

        return true;
    }
}
