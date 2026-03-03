<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'NaruBranch') }} - Masuk</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            @keyframes blob {
                0% { transform: translate(0px, 0px) scale(1); }
                33% { transform: translate(30px, -50px) scale(1.1); }
                66% { transform: translate(-20px, 20px) scale(0.9); }
                100% { transform: translate(0px, 0px) scale(1); }
            }
            .animate-blob { animation: blob 7s infinite; }
            .animation-delay-2000 { animation-delay: 2s; }
            .animation-delay-4000 { animation-delay: 4s; }
        </style>
        <!-- Dark Mode Initialization -->
        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
    </head>
    <body class="font-['Inter'] antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 selection:bg-purple-500 selection:text-white relative overflow-hidden min-h-screen flex items-center justify-center transition-colors duration-300">

        <!-- Abstract Background Shapes -->
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none opacity-40 dark:opacity-20 transition-opacity duration-300">
            <div class="absolute top-0 left-0 w-96 h-96 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-32 left-1/2 -ml-48 w-96 h-96 bg-pink-300 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob animation-delay-4000"></div>
        </div>

        <!-- Auth Card Container -->
        <div class="relative z-10 w-full sm:max-w-md px-6 py-10 bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl shadow-2xl overflow-hidden sm:rounded-3xl border border-white/50 dark:border-gray-700/50 m-4 transition-colors duration-300">
            
            <div class="flex justify-center mb-8">
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-600 to-blue-600 rounded-2xl flex items-center justify-center text-white font-bold text-3xl shadow-lg shadow-purple-500/30 group-hover:scale-110 transition-transform">
                        N
                    </div>
                    <span class="font-bold text-2xl tracking-tight text-gray-900 dark:text-white">Naru<span class="text-purple-600 dark:text-purple-400">Branch</span></span>
                </a>
            </div>

            <div class="mb-6 text-center">
                <h2 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 dark:from-purple-400 dark:to-blue-400 text-transparent bg-clip-text">Selamat Datang di NaruBranch</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Silakan masuk ke akun Anda</p>
            </div>

            {{ $slot }}
        </div>
    </body>
</html>
