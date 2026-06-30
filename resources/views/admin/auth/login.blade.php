<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Login - Ocean Life</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @include('components.assets')
</head>
<body class="min-h-screen font-sans antialiased">
    <div class="flex min-h-screen">
        <div class="hidden w-1/2 bg-gradient-to-br from-ocean-primary via-ocean-dark to-ocean-secondary lg:flex lg:flex-col lg:items-center lg:justify-center lg:p-12">
            <div class="max-w-md text-center text-white">
                <div class="mx-auto mb-8 flex h-20 w-20 items-center justify-center rounded-2xl bg-white/20 backdrop-blur-sm">
                    <svg class="h-12 w-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C8.5 2 5.5 4 4 7c-1.5 3-1 6.5 1 9.5C7 19.5 9.5 22 12 22s5-2.5 7-5.5c2-3 2.5-6.5 1-9.5C18.5 4 15.5 2 12 2z"/>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold">Ocean Life</h1>
                <p class="mt-4 text-lg text-white/80">Admin Dashboard — Manage your aquatic store with ease.</p>
                <div class="mt-12 flex justify-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-white/60"></span>
                    <span class="h-2 w-8 rounded-full bg-white"></span>
                    <span class="h-2 w-2 rounded-full bg-white/60"></span>
                </div>
            </div>
        </div>

        <div class="flex w-full flex-col items-center justify-center bg-gray-50 px-6 py-12 lg:w-1/2">
            <div class="w-full max-w-md">
                <div class="mb-8 text-center lg:text-left">
                    <div class="mb-4 flex items-center justify-center gap-2 lg:hidden">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-ocean-primary to-ocean-secondary">
                            <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C8.5 2 5.5 4 4 7c-1.5 3-1 6.5 1 9.5C7 19.5 9.5 22 12 22s5-2.5 7-5.5c2-3 2.5-6.5 1-9.5C18.5 4 15.5 2 12 2z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-gray-900">Ocean Life</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Welcome back</h2>
                    <p class="mt-2 text-sm text-gray-600">Sign in to your admin account</p>
                </div>

                @if($errors->any())
                    <div class="mb-6 rounded-xl bg-red-50 px-4 py-3 text-red-800 ring-1 ring-red-200">
                        <ul class="list-inside list-disc text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login') }}" class="card space-y-6 p-8">
                    @csrf

                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-gray-700">Email address</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="email"
                            class="input-field @error('email') border-red-500 ring-red-200 @enderror"
                            placeholder="admin@oceanlife.com"
                        >
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium text-gray-700">Password</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            autocomplete="current-password"
                            class="input-field @error('password') border-red-500 ring-red-200 @enderror"
                            placeholder="••••••••"
                        >
                    </div>

                    <div class="flex items-center">
                        <input
                            type="checkbox"
                            name="remember"
                            id="remember"
                            value="1"
                            {{ old('remember') ? 'checked' : '' }}
                            class="h-4 w-4 rounded border-gray-300 text-ocean-primary focus:ring-ocean-primary"
                        >
                        <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
                    </div>

                    <button type="submit" class="btn-primary w-full">
                        Sign in
                    </button>
                </form>

                <p class="mt-8 text-center text-sm text-gray-500">
                    <a href="{{ route('shop.home') }}" class="font-medium text-ocean-primary hover:text-ocean-dark">← Back to store</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
