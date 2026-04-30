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
            /* Abstract Floating Shapes */
            .bg-abstract {
                background: linear-gradient(135deg, #1e1b4b, #312e81);
                position: absolute;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                overflow: hidden;
                z-index: 0;
            }
            .dark .bg-abstract {
                background: linear-gradient(135deg, #020617, #0f172a);
            }
            .bg-abstract li {
                position: absolute;
                display: block;
                list-style: none;
                width: 20px;
                height: 20px;
                background: rgba(255, 255, 255, 0.05);
                border: 1px solid rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(5px);
                animation: animate 25s linear infinite;
                bottom: -150px;
                box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
            }
            .bg-abstract li:nth-child(1) { left: 25%; width: 80px; height: 80px; animation-delay: 0s; border-radius: 20%; background: linear-gradient(45deg, rgba(168,85,247,0.2), rgba(236,72,153,0.2)); }
            .bg-abstract li:nth-child(2) { left: 10%; width: 20px; height: 20px; animation-delay: 2s; animation-duration: 12s; border-radius: 50%; background: linear-gradient(45deg, rgba(59,130,246,0.2), rgba(147,51,234,0.2)); }
            .bg-abstract li:nth-child(3) { left: 70%; width: 20px; height: 20px; animation-delay: 4s; border-radius: 10%; }
            .bg-abstract li:nth-child(4) { left: 40%; width: 60px; height: 60px; animation-delay: 0s; animation-duration: 18s; border-radius: 50%; background: linear-gradient(45deg, rgba(236,72,153,0.2), rgba(244,63,94,0.2)); }
            .bg-abstract li:nth-child(5) { left: 65%; width: 20px; height: 20px; animation-delay: 0s; border-radius: 30%; }
            .bg-abstract li:nth-child(6) { left: 75%; width: 110px; height: 110px; animation-delay: 3s; border-radius: 50%; background: linear-gradient(45deg, rgba(99,102,241,0.2), rgba(168,85,247,0.2)); }
            .bg-abstract li:nth-child(7) { left: 35%; width: 150px; height: 150px; animation-delay: 7s; border-radius: 20%; background: linear-gradient(45deg, rgba(59,130,246,0.1), rgba(14,165,233,0.1)); }
            .bg-abstract li:nth-child(8) { left: 50%; width: 25px; height: 25px; animation-delay: 15s; animation-duration: 45s; border-radius: 50%; }
            .bg-abstract li:nth-child(9) { left: 20%; width: 15px; height: 15px; animation-delay: 2s; animation-duration: 35s; border-radius: 10%; }
            .bg-abstract li:nth-child(10) { left: 85%; width: 150px; height: 150px; animation-delay: 0s; animation-duration: 11s; border-radius: 30%; background: linear-gradient(45deg, rgba(168,85,247,0.15), rgba(236,72,153,0.15)); }

            @keyframes animate {
                0% { transform: translateY(0) rotate(0deg); opacity: 1; }
                100% { transform: translateY(-1000px) rotate(720deg); opacity: 0; }
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
    <body class="font-['Inter'] antialiased text-gray-900 dark:text-gray-100 selection:bg-purple-500 selection:text-white relative min-h-screen flex items-center justify-center transition-colors duration-300">

        <!-- Animated Abstract Background -->
        <ul class="bg-abstract">
            <li></li><li></li><li></li><li></li><li></li>
            <li></li><li></li><li></li><li></li><li></li>
        </ul>

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
