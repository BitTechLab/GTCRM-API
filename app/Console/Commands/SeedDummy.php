<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SeedDummy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:seed-dummy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed dummy data to table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (config('app.env') !== 'development' || !config('app.debug')) {
            $this->error('Seeding dummy data can only run in development mode and when debug is on. Make sure APP_ENV=development and APP_DEBUG=true to run dummy seeder');
            return;
        }

        $models = [
            \App\Models\Customer::class,
            \App\Models\Lead::class,
            \App\Models\Address::class,
        ];


        foreach ($models as $model) {
            try {
                $model::factory()->times(100)->create();
                $this->info("Success: seed dummy data for: {$model}");
            } catch (\Exception $e) {
                $this->error("Error: seed dummy data for: {$model} | with error message {$e->getMessage()}");
            }
        }
    }
}
