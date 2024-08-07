<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use function Laravel\Prompts\progress;

class SeedDummy extends Command
{
    const ITEM_PER_MODEL = 100;
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
    public function handle(): void
    {
        if (config('app.env') !== 'development' || !config('app.debug')) {
            $this->error('Seeding dummy data can only run in development mode and when debug is on. Make sure APP_ENV=development and APP_DEBUG=true to run dummy seeder');
            return;
        }

        $models = [
            \App\Models\Customer::class,
            \App\Models\Lead::class,
            // \App\Models\Address::class,
        ];


        // $progress = progress(label: "{$this->signature} - Inserting dummy data", steps: count($models) * self::ITEM_PER_MODEL);
        // $progress->start();

        foreach ($models as $model) {
            try {
                $model::factory()->times(self::ITEM_PER_MODEL)->create();
                $this->info("\nSuccess: seed dummy data for: {$model}");
            } catch (\Exception $e) {
                $this->error("\nError: seed dummy data for: {$model} | with error message {$e->getMessage()}");
            }

            // $progress->advance(self::ITEM_PER_MODEL);
        }

        // $progress->finish();

        $this->info("{$this->signature} - Processing complete\n");
    }
}
