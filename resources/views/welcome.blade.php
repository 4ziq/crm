<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CRM System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">

    <div class="max-w-4xl w-full px-6">
        <div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-10 text-center">

            <!-- Logo / Title -->
            <h1 class="text-3xl font-bold text-gray-800">
                CRM Management System
            </h1>

            <p class="mt-3 text-gray-500">
                Manage customers, interactions and support tickets efficiently.
            </p>

            <!-- Buttons -->
            <div class="mt-8 flex justify-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="px-6 py-3 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 transition">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-6 py-3 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 transition">
                        Login
                    </a>

                    {{-- <a href="{{ route('register') }}"
                       class="px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-100 transition">
                        Register
                    </a> --}}
                @endauth
            </div>

        </div>

        <!-- Simple Footer -->
        <div class="mt-6 text-center text-xs text-gray-400">
            © {{ date('Y') }} CRM System. All rights reserved.
        </div>
    </div>

</body>
</html>
