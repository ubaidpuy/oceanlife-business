@extends('layouts.admin')

@section('title', 'Categories')
@section('page-title', 'Categories')

@section('content')
    <div x-data="{ deleteSlug: null, deleteName: '' }">
        <div class="mb-6 flex items-center justify-between">
            <p class="text-sm text-gray-600">Manage product categories</p>
            <a href="{{ route('admin.categories.create') }}" class="btn-primary">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Category
            </a>
        </div>

        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wider text-gray-500">
                        <tr>
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Slug</th>
                            <th class="px-6 py-3">Products</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($categories as $category)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($category->image_url)
                                            <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="h-10 w-10 rounded-lg object-cover">
                                        @else
                                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 text-gray-400">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                        @endif
                                        <span class="font-medium text-gray-900">{{ $category->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-500">{{ $category->slug }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $category->products_count }}</td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('admin.categories.toggle-status', $category) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-ocean-primary focus:ring-offset-2 {{ $category->status ? 'bg-ocean-primary' : 'bg-gray-200' }}">
                                            <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $category->status ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="rounded-lg px-3 py-1.5 text-sm font-medium text-ocean-primary hover:bg-ocean-primary/10">Edit</a>
                                        <button
                                            type="button"
                                            @click="deleteSlug = @js($category->slug); deleteName = @js($category->name)"
                                            class="rounded-lg px-3 py-1.5 text-sm font-medium text-red-600 hover:bg-red-50"
                                        >Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($categories->hasPages())
                <div class="border-t border-gray-100 px-6 py-4">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>

        <div
            x-show="deleteSlug !== null"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
            @keydown.escape.window="deleteSlug = null"
        >
            <div
                x-show="deleteSlug !== null"
                x-transition
                @click.outside="deleteSlug = null"
                class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl"
            >
                <h3 class="text-lg font-semibold text-gray-900">Delete Category</h3>
                <p class="mt-2 text-sm text-gray-600">
                    Are you sure you want to delete <span class="font-medium" x-text="deleteName"></span>? This action cannot be undone.
                </p>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="deleteSlug = null" class="btn-outline px-4 py-2">Cancel</button>
                    <form :action="`{{ url('admin/categories') }}/${deleteSlug}`" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
