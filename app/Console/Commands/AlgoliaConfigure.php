<?php

namespace App\Console\Commands;

use App\Services\AlgoliaService;
use Illuminate\Console\Command;
use Throwable;

class AlgoliaConfigure extends Command
{
    protected $signature = 'algolia:configure';

    protected $description = 'Configure the unified Algolia storefront index';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        try {
            $client = AlgoliaService::client();

            $client->setSettings(AlgoliaService::indexName(), [
                'searchableAttributes' => ['name', 'category_name', 'description'],
                'attributesForFaceting' => ['filterOnly(type)', 'filterOnly(category_id)', 'featured', 'filterOnly(stock)'],
                'customRanking' => ['desc(featured)', 'asc(price)'],
            ]);
            $this->info('Configured unified index: ' . AlgoliaService::indexName());

            return Command::SUCCESS;
        } catch (Throwable $e) {
            $this->error($e->getMessage());

            return Command::FAILURE;
        }
    }
}
