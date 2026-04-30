<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Selamat datang, {{ Auth::user()->name }}
            <span class="block text-sm text-gray-500 font-normal mt-1">Login sebagai: Divisi {{ Auth::user()->division->name ?? 'Belum Ada' }} - {{ Auth::user()->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Semua Project Divisi</h3>
                <a href="{{ route('projects.create') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl shadow transition-colors">
                    + Tambah Project
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Table Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Judul Project</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Deadline</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Divisi</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Pembuat</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Dibuat</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($projects as $project)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-900 dark:text-white">{{ $project->title }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ Str::limit($project->description, 60) ?: '-' }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm {{ $project->deadline && \Carbon\Carbon::parse($project->deadline)->isPast() && $project->status !== 'done' ? 'text-red-500 font-bold' : 'text-gray-500 dark:text-gray-400' }}">
                                {{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->format('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($project->status === 'pending')
                                    <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-300 rounded-full text-sm font-medium">Pending</span>
                                @elseif($project->status === 'ongoing')
                                    <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300 rounded-full text-sm font-medium">Ongoing</span>
                                @else
                                    <span class="px-3 py-1 bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300 rounded-full text-sm font-medium">Done</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300 font-medium">{{ $project->division->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $project->user->name ?? 'Admin/Sistem' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $project->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                @if($project->division_id == Auth::user()->division_id)
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('projects.edit', $project->id) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium">Edit</a>
                                    <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Hapus project ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 font-medium">Hapus</button>
                                    </form>
                                </div>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500 italic text-sm">Hanya Lihat</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">Belum ada project di divisi Anda.</td>
                        @endforelse
                    </tbody>
                </table>
                <div class="bg-gray-50 dark:bg-gray-800 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $projects->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
