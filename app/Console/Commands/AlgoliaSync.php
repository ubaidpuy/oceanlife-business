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

    protected $description = 'Sync products and/or categories to Algolia';

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

            $client = AlgoliaService::client();

            if ($model === null || $model === 'products') {
                if ($this->option('clear')) {
                    $client->clearObjects('products');
                    $this->info('Cleared products index.');
                }

                Product::with(['category', 'images'])
                    ->where('status', true)
                    ->chunk(500, function ($products) use ($client): void {
                        $records = $products->map->toAlgoliaArray()->toArray();

                        if ($records !== []) {
                            $client->saveObjects('products', $records);
                        }
                    });

                $this->info('Synced ' . Product::where('status', true)->count() . ' products.');
            }

            if ($model === null || $model === 'categories') {
                if ($this->option('clear')) {
                    $client->clearObjects('categories');
                    $this->info('Cleared categories index.');
                }

                Category::where('status', true)
                    ->chunk(500, function ($categories) use ($client): void {
                        $records = $categories->map->toAlgoliaArray()->toArray();

                        if ($records !== []) {
                            $client->saveObjects('categories', $records);
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
