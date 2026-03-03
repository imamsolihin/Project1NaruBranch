<x-app-layout>
    <div class="p-6 bg-gray-100 min-h-screen">

        <h1 class="text-2xl font-bold text-gray-800 mb-4">
            Tambah Project
        </h1>

        <form action="{{ route('admin.projects.store') }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700">Nama Project</label>
                <input type="text" name="title" class="w-full border rounded px-3 py-2 mt-1" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Deskripsi</label>
                <textarea name="description" class="w-full border rounded px-3 py-2 mt-1"></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Divisi</label>
                <select name="division_id" class="w-full border rounded px-3 py-2 mt-1">
                    @foreach($divisions as $division)
                        <option value="{{ $division->id }}">
                            {{ $division->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                Simpan
            </button>
        </form>

    </div>
</x-app-layout>