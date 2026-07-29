<?php

namespace App\Services;

use Algolia\AlgoliaSearch\Api\SearchClient;

class AlgoliaService
{
    /**
     * The single index shared by every searchable storefront record.
     */
    public static function indexName(): string
    {
        return (string) config('services.algolia.index', 'ocean_life');
    }

    /**
     * Create an Algolia search client using the backend write key.
     */
    public static function client(): SearchClient
    {
        return SearchClient::create(config('services.algolia.app_id'), env('ALGOLIA_ADMIN_KEY'));
    }
}
