<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'LinkTree Clone') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between">
                <div class="flex space-x-7">
                    <a href="/" class="flex items-center py-4">
                        <span class="font-semibold text-gray-500 text-lg">LinkTree Clone</span>
                    </a>
                </div>
                <div class="flex items-center space-x-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="py-2 px-4 text-gray-500 hover:text-gray-700">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="py-2 px-4 bg-red-500 text-white rounded hover:bg-red-600">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="py-2 px-4 text-gray-500 hover:text-gray-700">Login</a>
                        <a href="{{ route('register') }}" class="py-2 px-4 bg-purple-600 text-white rounded hover:bg-purple-700">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="min-h-screen">
        @yield('content')
    </main>

    <footer class="bg-white shadow-lg mt-8">
        <div class="max-w-6xl mx-auto py-4 px-4 text-center text-gray-500">
            <p>&copy; {{ date('Y') }} LinkTree Clone. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
