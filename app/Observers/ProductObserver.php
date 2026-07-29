<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\AlgoliaService;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProductObserver
{
    /**
     * Sync a saved product to Algolia.
     */
    public function saved(Product $product): void
    {
        try {
            $client = AlgoliaService::client();

            if ($product->status) {
                $product->loadMissing(['category', 'images']);
                $client->saveObject(AlgoliaService::indexName(), $product->toAlgoliaArray());
            } else {
                $client->deleteObject(AlgoliaService::indexName(), 'product_' . $product->id);
            }
        } catch (Throwable $e) {
            Log::error('Algolia product sync failed: ' . $e->getMessage());
        }
    }

    /**
     * Remove a deleted product from Algolia.
     */
    public function deleted(Product $product): void
    {
        try {
            AlgoliaService::client()->deleteObject(AlgoliaService::indexName(), 'product_' . $product->id);
        } catch (Throwable $e) {
            Log::error('Algolia product sync failed: ' . $e->getMessage());
        }
    }
}
