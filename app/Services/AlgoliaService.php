<?php

namespace App\Services;

use Algolia\AlgoliaSearch\Api\SearchClient;

class AlgoliaService
{
    /**
     * Create an Algolia search client using the backend write key.
     */
    public static function client(): SearchClient
    {
        return SearchClient::create(env('ALGOLIA_APP_ID'), env('ALGOLIA_ADMIN_KEY'));
    }
}
