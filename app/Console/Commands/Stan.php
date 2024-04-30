<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class Stan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run PHPStan for the project';

    /**
     * Execute the console command.
     */
    public function handle(): string
    {
        // ini_set('max_execution_time', 0);

        $result = Process::run('php -d max_execution_time=0 ./vendor/bin/phpstan analyse -c phpstan.neon');

        return $result->output();
    }
}
