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
            'q' => ['required', 'string', 'min:3', 'max:100'],
            'category_id' => ['nullable', 'integer'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:20'],
        ]);

        $client = AlgoliaService::client();
        $perPage = $validated['per_page'] ?? 8;
        $params = ['hitsPerPage' => $perPage + 3];

        if ($request->filled('category_id')) {
            $params['filters'] = 'category_id:' . $validated['category_id'];
        }

        $searchResults = $client->searchSingleIndex(AlgoliaService::indexName(), [
            ...$params,
            'query' => $validated['q'],
        ]);
        $hits = collect($searchResults['hits']);

        return response()->json([
            'categories' => $hits->where('type', 'category')->take(3)->values(),
            'products' => $hits->where('type', 'product')->take($perPage)->values(),
        ]);
    }
}
