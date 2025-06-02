<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net"> 
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="hidden md:block w-64 bg-white dark:bg-gray-800 shadow-md p-4">
            <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Dashboard</h2>
            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <i class="fas fa-tachometer-alt me-2"></i> Beranda
                </a>

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.users') }}" class="block px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                        <i class="fas fa-users me-2"></i> Kelola Pengguna
                    </a>
                    <a href="{{ route('admin.ukms') }}" class="block px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                        <i class="fas fa-building me-2"></i> Kelola UKM
                    </a>
                @endif

                @if(auth()->user()->role === 'ukm')
                    <a href="{{ route('ukm.events') }}" class="block px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                        <i class="fas fa-calendar me-2"></i> Event Saya
                    </a>
                    <a href="#" class="block px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition"> 
                        <i class="fas fa-newspaper me-2"></i> Postingan
                    </a>
                @endif

                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <i class="fas fa-user-circle me-2"></i> Profil
                </a>

                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded hover:bg-red-100 dark:hover:bg-red-900 text-red-600 dark:text-red-400 transition">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header -->
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Custom Scripts -->
    @stack('scripts')
</body>

</html>