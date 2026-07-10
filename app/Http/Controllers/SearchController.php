<?php

namespace App\Http\Controllers;

use App\Services\AlgoliaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Search products and categories in Algolia.
     */
    public function search(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'q' => ['required', 'string'],
            'category_id' => ['nullable', 'integer'],
            'per_page' => ['nullable', 'integer'],
        ]);

        $client = AlgoliaService::client();
        $productParams = ['hitsPerPage' => $validated['per_page'] ?? 20];

        if ($request->filled('category_id')) {
            $productParams['filters'] = 'category_id:' . $validated['category_id'];
        }

        $productResults = $client->searchSingleIndex('products', [
            ...$productParams,
            'query' => $validated['q'],
        ]);
        $categoryResults = $client->searchSingleIndex('categories', [
            'hitsPerPage' => 5,
            'query' => $validated['q'],
        ]);

        return response()->json([
            'products' => $productResults['hits'],
            'categories' => $categoryResults['hits'],
            'products_count' => $productResults['nbHits'],
        ]);
    }
}
