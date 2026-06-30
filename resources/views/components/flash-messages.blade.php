@if(session('success') || session('error') || session('warning') || $errors->any())
<div
    x-data="{ show: true }"
    x-show="show"
    x-init="setTimeout(() => show = false, 5000)"
    class="fixed right-4 top-4 z-50 max-w-sm space-y-2"
>
    @if(session('success'))
        <div class="flex items-center gap-3 rounded-xl bg-green-50 px-4 py-3 text-green-800 shadow-lg ring-1 ring-green-200">
            <svg class="h-5 w-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
            <button @click="show = false" class="ml-auto text-green-600 hover:text-green-800">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="flex items-center gap-3 rounded-xl bg-red-50 px-4 py-3 text-red-800 shadow-lg ring-1 ring-red-200">
            <svg class="h-5 w-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
            <span class="text-sm font-medium">{{ session('error') }}</span>
            <button @click="show = false" class="ml-auto text-red-600 hover:text-red-800">&times;</button>
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-xl bg-red-50 px-4 py-3 text-red-800 shadow-lg ring-1 ring-red-200">
            <ul class="list-inside list-disc text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endif
