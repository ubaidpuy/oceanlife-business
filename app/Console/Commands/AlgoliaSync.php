<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use App\Services\AlgoliaService;
use Illuminate\Console\Command;
use Throwable;

class AlgoliaSync extends Command
{
    protected $signature = 'algolia:sync {model?} {--clear}';

    protected $description = 'Sync products and categories to the unified Algolia index';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        try {
            $model = $this->argument('model');

            if ($model !== null && ! in_array($model, ['products', 'categories'], true)) {
                $this->error('Model must be products or categories.');

                return Command::FAILURE;
            }

            if ($model !== null && $this->option('clear')) {
                $this->error('The --clear option rebuilds the unified index and cannot be combined with a model.');

                return Command::FAILURE;
            }

            $client = AlgoliaService::client();

            if ($this->option('clear')) {
                $client->clearObjects(AlgoliaService::indexName());
                $this->info('Cleared unified index: ' . AlgoliaService::indexName());
            }

            if ($model === null || $model === 'products') {
                Product::with(['category', 'images'])
                    ->where('status', true)
                    ->chunk(500, function ($products) use ($client): void {
                        $records = $products->map->toAlgoliaArray()->toArray();

                        if ($records !== []) {
                            $client->saveObjects(AlgoliaService::indexName(), $records);
                        }
                    });

                $this->info('Synced ' . Product::where('status', true)->count() . ' products.');
            }

            if ($model === null || $model === 'categories') {
                Category::where('status', true)
                    ->chunk(500, function ($categories) use ($client): void {
                        $records = $categories->map->toAlgoliaArray()->toArray();

                        if ($records !== []) {
                            $client->saveObjects(AlgoliaService::indexName(), $records);
                        }
                    });

                $this->info('Synced ' . Category::where('status', true)->count() . ' categories.');
            }

            return Command::SUCCESS;
        } catch (Throwable $e) {
            $this->error($e->getMessage());

            return Command::FAILURE;
        }
    }
}
