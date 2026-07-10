<?php

namespace App\Console\Commands;

use App\Services\AlgoliaService;
use Illuminate\Console\Command;
use Throwable;

class AlgoliaConfigure extends Command
{
    protected $signature = 'algolia:configure';

    protected $description = 'Configure Algolia index settings for products and categories';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        try {
            $client = AlgoliaService::client();

            $client->setSettings('products', [
                'searchableAttributes' => ['name', 'category_name', 'description'],
                'attributesForFaceting' => ['category_id', 'featured', 'filterOnly(stock)'],
                'customRanking' => ['desc(featured)', 'asc(price)'],
            ]);
            $this->info('Configured products index.');

            $client->setSettings('categories', [
                'searchableAttributes' => ['name'],
            ]);
            $this->info('Configured categories index.');

            return Command::SUCCESS;
        } catch (Throwable $e) {
            $this->error($e->getMessage());

            return Command::FAILURE;
        }
    }
}
