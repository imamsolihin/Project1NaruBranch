<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NaruBranch - Project Management</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts / Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Dark Mode Initialization -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body x-data="{ darkMode: false }" x-init="darkMode = document.documentElement.classList.contains('dark'); $watch('darkMode', val => { if(val) { document.documentElement.classList.add('dark'); localStorage.theme = 'dark'; } else { document.documentElement.classList.remove('dark'); localStorage.theme = 'light'; } })" class="font-['Inter'] antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 selection:bg-purple-500 selection:text-white transition-colors duration-300">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 transition-colors duration-300 backdrop-blur-md bg-white/70 dark:bg-gray-900/70 border-b border-gray-100 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-purple-500/30">
                        N
                    </div>
                    <span class="font-bold text-xl tracking-tight">Naru<span class="text-purple-600 dark:text-purple-400">Branch</span></span>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode" class="p-2 mr-2 rounded-full text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white bg-gray-100 dark:bg-gray-800 transition-colors duration-200">
                        <!-- Sun icon for dark mode -->
                        <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <!-- Moon icon for light mode -->
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                    </button>

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
                                Ke Dashboard &rarr;
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-sm font-medium bg-gray-900 dark:bg-white text-white dark:text-gray-900 px-5 py-2.5 rounded-full hover:bg-gray-800 dark:hover:bg-gray-100 transition-all shadow-md hover:shadow-xl hover:-translate-y-0.5 transform">
                                    Daftar Sekarang
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <!-- Abstract Background Shapes -->
        <div class="absolute inset-0 z-0 opacity-100 dark:opacity-30 transition-opacity duration-300">
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-purple-300 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-300 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
            <div class="absolute top-48 left-1/2 -ml-48 w-96 h-96 bg-pink-300 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-50 dark:bg-purple-900/30 border border-purple-100 dark:border-purple-800 text-purple-600 dark:text-purple-300 text-sm font-medium mb-8">
                <span class="flex h-2 w-2 relative">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-purple-500"></span>
                </span>
                Sistem Manajemen Project Versi 2.0
            </div>
            
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-8">
                Kelola Divisi & Project<br />
                <span class="bg-gradient-to-r from-purple-600 to-blue-600 dark:from-purple-400 dark:to-blue-400 text-transparent bg-clip-text">Lebih Terstruktur</span>
            </h1>
            
            <p class="max-w-2xl mx-auto text-lg md:text-xl text-gray-600 dark:text-gray-400 mb-10 leading-relaxed">
                NaruBranch membantu institusi Anda mengatur setiap proyek dari berbagai divisi secara terpusat. Pantau progres, bagikan tugas, dan capai target dengan lebih elegan.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto px-8 py-4 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-full font-medium hover:bg-gray-800 dark:hover:bg-gray-100 transition-all shadow-xl hover:shadow-2xl hover:-translate-y-1 transform">
                            Buka Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-full font-medium hover:bg-gray-800 dark:hover:bg-gray-100 transition-all shadow-xl hover:shadow-2xl hover:-translate-y-1 transform">
                            Masuk ke Akun
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-800 dark:text-white rounded-full font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm hover:shadow-md">
                                Buat Akun Baru
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-20 bg-white dark:bg-gray-950 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Fitur Utama</h2>
                <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Sistem yang didesain khusus untuk memudahkan pengelolaan operasional antar divisi.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="p-8 rounded-3xl bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 hover:shadow-xl dark:hover:shadow-purple-900/20 transition-all duration-300 hover:-translate-y-1 group">
                    <div class="w-14 h-14 bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-400 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Multi-Divisi</h3>
                    <p class="text-gray-600 dark:text-gray-400">Pisahkan ruang kerja proyek berdasarkan divisi agar setiap anggota tim dapat lebih fokus.</p>
                </div>

                <!-- Feature 2 -->
                <div class="p-8 rounded-3xl bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 hover:shadow-xl dark:hover:shadow-blue-900/20 transition-all duration-300 hover:-translate-y-1 group">
                    <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Executive Monitor</h3>
                    <p class="text-gray-600 dark:text-gray-400">Admin/Eksekutif dapat memantau seluruh status project "Pending, Ongoing, Done" dari satu dashboard.</p>
                </div>

                <!-- Feature 3 -->
                <div class="p-8 rounded-3xl bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 hover:shadow-xl dark:hover:shadow-pink-900/20 transition-all duration-300 hover:-translate-y-1 group">
                    <div class="w-14 h-14 bg-pink-100 dark:bg-pink-900/50 text-pink-600 dark:text-pink-400 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Role-Based Access</h3>
                    <p class="text-gray-600 dark:text-gray-400">Sistem keamanan cerdas yang memastikan user hanya bisa memanipulasi data di divisinya sendiri.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 py-12 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-500 dark:text-gray-400">
            <p>&copy; {{ date('Y') }} NaruBranch. All rights reserved.</p>
            <p class="mt-2 text-sm">Designed with Elegance.</p>
        </div>
    </footer>

    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</body>
</html>
