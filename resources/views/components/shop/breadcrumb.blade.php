@props(['items' => []])

@if(count($items))
<nav class="mb-6 flex items-center gap-2 text-sm text-gray-500">
    <a href="{{ route('shop.home') }}" class="hover:text-ocean-primary">Home</a>
    @foreach($items as $label => $url)
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        @if($url)
            <a href="{{ $url }}" class="hover:text-ocean-primary">{{ $label }}</a>
        @else
            <span class="font-medium text-gray-900 dark:text-white">{{ $label }}</span>
        @endif
    @endforeach
</nav>
@endif
