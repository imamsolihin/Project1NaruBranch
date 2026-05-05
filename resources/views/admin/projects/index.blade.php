<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Monitor Semua Project</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Daftar semua project dari seluruh divisi</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.projects.create') }}" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl shadow transition-colors">
                        + Tambah Project
                    </a>
                    <form method="GET" action="{{ route('admin.projects.index') }}" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pembuat..." class="pl-10 pr-4 py-2 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-xl w-64 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </form>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-x-auto border border-gray-100 dark:border-gray-700">
                <table class="w-full min-w-[800px]">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Project</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Divisi / Tujuan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Pembuat</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Deadline</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Tgl Dibuat</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($projects as $project)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-900 dark:text-white">{{ $project->title }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($project->description, 50) }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/50 text-purple-700 dark:text-purple-300 rounded-full text-sm font-medium">
                                    {{ $project->divisions->pluck('name')->join(', ') ?: 'Tanpa Divisi' }}
                                </span>
                                @if($project->assignedUsers->count() > 0)
                                <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    <strong>User:</strong> {{ $project->assignedUsers->pluck('name')->join(', ') }}
                                </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                {{ $project->user->name ?? 'Admin/Sistem' }}
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
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $project->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.projects.edit', $project->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">Edit</a>
                                    <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Hapus project ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">Belum ada project yang dikerjakan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                    {{ $projects->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
