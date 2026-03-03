<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 dark:from-purple-400 dark:to-blue-400 text-transparent bg-clip-text">Pilih Divisi Anda</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Untuk melanjutkan ke Dashboard, silakan pilih divisi Anda saat ini.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('division.store') }}" class="space-y-6">
        @csrf

        <div>
            <label for="division_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pilih Divisi</label>
            <div class="relative">
                <select id="division_id" name="division_id" required 
                        class="block w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:bg-white dark:focus:bg-gray-900 focus:border-purple-500 focus:ring-purple-500 shadow-sm appearance-none py-3 pl-4 pr-10 transition-colors">
                    <option value="" disabled selected>-- Pilih Divisi --</option>
                    @foreach($divisions as $division)
                        <option value="{{ $division->id }}">{{ $division->name }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500 dark:text-gray-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
            <x-input-error :messages="$errors->get('division_id')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full justify-center inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                Konfirmasi Divisi
            </button>
        </div>

        <!-- Optional: Logout button if they want to switch account -->
        <div class="text-center mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Bukan akun Anda?
                <button type="button" onclick="document.getElementById('logout-form').submit();" class="font-medium text-red-600 dark:text-red-400 hover:underline">
                    Keluar di sini
                </button>
            </p>
        </div>
    </form>
    
    <!-- Hidden Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</x-guest-layout>
