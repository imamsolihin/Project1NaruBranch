<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400 leading-relaxed text-center">
        Lupa password Anda? Tidak masalah. Beritahu kami alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang password baru.
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
            <input id="email" class="block w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:bg-white dark:focus:bg-gray-900 focus:border-purple-500 focus:ring-purple-500 transition-colors shadow-sm" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="john@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full justify-center inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                Kirim Tautan Reset Password
            </button>
        </div>

        <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-6">
            Ingat password Anda? 
            <a href="{{ route('login') }}" class="font-medium text-purple-600 dark:text-purple-400 hover:text-purple-500 dark:hover:text-purple-300 transition-colors">Masuk di sini</a>
        </p>
    </form>
</x-guest-layout>
