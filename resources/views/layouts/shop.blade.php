<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', mobileMenu: false }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $shopSettings->shop_name ?? 'Ocean Life')</title>
    <meta name="description" content="@yield('meta_description', 'Premium aquarium supplies, fish, and accessories at Ocean Life.')">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @include('components.assets')
    @stack('styles')
</head>
<body class="min-h-screen bg-gray-50 font-sans antialiased dark:bg-gray-900">
    @include('components.shop.navbar')

    <main>
        @include('components.flash-messages')
        @yield('content')
    </main>

    @include('components.shop.footer')

    @stack('scripts')
</body>
</html>
