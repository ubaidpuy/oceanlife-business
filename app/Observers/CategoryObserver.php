<?php

namespace App\Observers;

use App\Models\Category;
use App\Services\AlgoliaService;
use Illuminate\Support\Facades\Log;
use Throwable;

class CategoryObserver
{
    /**
     * Sync a saved category to Algolia.
     */
    public function saved(Category $category): void
    {
        try {
            $client = AlgoliaService::client();

            if ($category->status) {
                $client->saveObject('categories', $category->toAlgoliaArray());
            } else {
                $client->deleteObject('categories', (string) $category->id);
            }
        } catch (Throwable $e) {
            Log::error('Algolia category sync failed: ' . $e->getMessage());
        }
    }

    /**
     * Remove a deleted category from Algolia.
     */
    public function deleted(Category $category): void
    {
        try {
            AlgoliaService::client()->deleteObject('categories', (string) $category->id);
        } catch (Throwable $e) {
            Log::error('Algolia category sync failed: ' . $e->getMessage());
        }
    }
}
