<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Monitor Semua Project</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Daftar semua project dari seluruh divisi</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-x-auto border border-gray-100 dark:border-gray-700">
                <table class="w-full min-w-[800px]">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Project</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Divisi</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Deadline</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Tgl Dibuat</th>
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
                                    {{ $project->division->name ?? 'Tanpa Divisi' }}
                                </span>
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
                        </tr>
                        @empty
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">Belum ada project yang dikerjakan.</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
