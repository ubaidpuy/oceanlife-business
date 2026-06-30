<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') - {{ $shopSettings->shop_name ?? 'Ocean Life' }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @include('components.assets')
    @stack('styles')
</head>
<body class="min-h-screen bg-gray-100 font-sans antialiased" x-data="{ sidebarOpen: false }">
    <div class="flex min-h-screen">
        @include('components.admin.sidebar')

        <div class="flex flex-1 flex-col lg:pl-64">
            <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-gray-200 bg-white px-4 shadow-sm lg:px-8">
                <button @click="sidebarOpen = !sidebarOpen" class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 lg:hidden">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-lg font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                <div class="flex items-center gap-4">
                    <span class="hidden text-sm text-gray-600 sm:block">{{ auth('admin')->user()->name }}</span>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-700">Logout</button>
                    </form>
                </div>
            </header>

            <main class="flex-1 p-4 lg:p-8">
                @include('components.flash-messages')
                @yield('content')
            </main>
        </div>
    </div>

    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black/50 lg:hidden" x-cloak></div>

    @stack('scripts')
</body>
</html>
