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
            @keyframes gradient {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }
            @keyframes slideUpFade {
                0% { opacity: 0; transform: translateY(30px); }
                100% { opacity: 1; transform: translateY(0); }
            }
            .animate-gradient {
                background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
                background-size: 400% 400%;
                animation: gradient 15s ease infinite;
            }
            .dark .animate-gradient {
                background: linear-gradient(-45deg, #1e1b4b, #312e81, #1e3a8a, #172554);
                background-size: 400% 400%;
                animation: gradient 15s ease infinite;
            }
            .animate-slide-up {
                animation: slideUpFade 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                opacity: 0;
            }
            .delay-100 { animation-delay: 100ms; }
            .delay-200 { animation-delay: 200ms; }
            .delay-300 { animation-delay: 300ms; }
            .delay-400 { animation-delay: 400ms; }
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
    <body class="font-['Inter'] antialiased text-gray-900 dark:text-gray-100 selection:bg-purple-500 selection:text-white relative overflow-hidden min-h-screen flex items-center justify-center transition-colors duration-300 animate-gradient">

        <!-- Abstract Background Particles (Optional overlay) -->
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0IiBoZWlnaHQ9IjQiPgo8cmVjdCB3aWR0aD0iNCIgaGVpZ2h0PSI0IiBmaWxsPSIjZmZmIiBmaWxsLW9wYWNpdHk9IjAuMDUiLz4KPC9zdmc+')] opacity-50">
        </div>

        <!-- Auth Card Container -->
        <div class="relative z-10 w-full sm:max-w-md px-6 py-10 bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl shadow-2xl overflow-hidden sm:rounded-3xl border border-white/50 dark:border-gray-700/50 m-4 transition-colors duration-300 animate-slide-up">
            
            <div class="flex justify-center mb-8 animate-slide-up delay-100">
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-600 to-blue-600 rounded-2xl flex items-center justify-center text-white font-bold text-3xl shadow-lg shadow-purple-500/30 group-hover:scale-110 transition-transform">
                        N
                    </div>
                    <span class="font-bold text-2xl tracking-tight text-gray-900 dark:text-white">Naru<span class="text-purple-600 dark:text-purple-400">Branch</span></span>
                </a>
            </div>

            <div class="mb-6 text-center animate-slide-up delay-200">
                <h2 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 dark:from-purple-400 dark:to-blue-400 text-transparent bg-clip-text">Selamat Datang di NaruBranch</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Silakan masuk ke akun Anda</p>
            </div>

            <div class="animate-slide-up delay-300">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
