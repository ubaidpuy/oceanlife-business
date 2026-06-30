@props(['category'])

<a href="{{ route('shop.categories.show', $category) }}" class="card group block overflow-hidden p-6 text-center">
    <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center overflow-hidden rounded-2xl bg-gradient-to-br from-ocean-primary/10 to-ocean-secondary/10 transition group-hover:from-ocean-primary/20 group-hover:to-ocean-secondary/20">
        @if($category->image_url)
            <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="h-full w-full object-cover">
        @else
            <svg class="h-10 w-10 text-ocean-primary transition group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.5 2 5.5 4 4 7c-1.5 3-1 6.5 1 9.5C7 19.5 9.5 22 12 22s5-2.5 7-5.5c2-3 2.5-6.5 1-9.5C18.5 4 15.5 2 12 2z"/></svg>
        @endif
    </div>
    <h3 class="font-semibold text-gray-900 transition group-hover:text-ocean-primary dark:text-white">{{ $category->name }}</h3>
    <p class="mt-1 text-sm text-gray-500">{{ $category->products_count ?? 0 }} products</p>
</a>
