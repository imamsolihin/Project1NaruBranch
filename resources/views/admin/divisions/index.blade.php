<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Manajemen Divisi</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Daftar semua divisi di perusahaan</p>
                </div>
                <a href="{{ route('admin.divisions.create') }}" class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-xl shadow-lg transition-all duration-200">
                    + Tambah Divisi
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-x-auto border border-gray-100 dark:border-gray-700">
                <table class="w-full min-w-[600px]">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Nama Divisi</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($divisions as $division)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $division->id }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">{{ $division->name }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.divisions.edit', $division->id) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium">Edit</a>
                                    <form action="{{ route('admin.divisions.destroy', $division->id) }}" method="POST" onsubmit="return confirm('Hapus divisi ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 font-medium">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">Belum ada divisi yang terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                    {{ $divisions->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
