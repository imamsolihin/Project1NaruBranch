<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Edit Project</h1>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 p-8">
                <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Project</label>
                        <input type="text" name="title" class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500" value="{{ old('title', $project->title) }}" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi</label>
                        <textarea name="description" class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 min-h-[100px]">{{ old('description', $project->description) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deadline</label>
                        <input type="date" name="deadline" class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500" value="{{ old('deadline', $project->deadline) }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tujuan Divisi (Bisa pilih lebih dari satu)</label>
                        <select name="division_ids[]" multiple class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 min-h-[100px]" required>
                    @foreach($divisions as $division)
                        <option value="{{ $division->id }}" {{ in_array($division->id, old('division_ids', $project->divisions->pluck('id')->toArray())) ? 'selected' : '' }}>
                            {{ $division->name }}
                        </option>
                    @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Tahan tombol Ctrl (Windows) / Command (Mac) untuk memilih lebih dari satu.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tujuan User (Opsional, Bisa pilih lebih dari satu)</label>
                        <select name="assigned_user_ids[]" multiple class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 min-h-[120px]">
                    @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ in_array($u->id, old('assigned_user_ids', $project->assignedUsers->pluck('id')->toArray())) ? 'selected' : '' }}>
                            {{ $u->name }} ({{ $u->division->name ?? 'Tanpa Divisi' }})
                        </option>
                    @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Tahan tombol Ctrl (Windows) / Command (Mac) untuk memilih lebih dari satu.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select name="status" class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500" required>
                    <option value="pending" {{ old('status', $project->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="ongoing" {{ old('status', $project->status) == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="done" {{ old('status', $project->status) == 'done' ? 'selected' : '' }}>Done</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <a href="{{ route('admin.projects.index') }}" class="px-6 py-3 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">Batal</a>
                        <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl shadow transition-colors">Update Project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
