<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard NaruBranch
        </h2>
    </x-slot>

    <div class="py-6 px-6">
        <!-- Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

            <div class="bg-white p-5 rounded-2xl shadow">
                <h3 class="text-gray-500 text-sm">Total Project</h3>
                <p class="text-2xl font-bold">12</p>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow">
                <h3 class="text-gray-500 text-sm">Project Ongoing</h3>
                <p class="text-2xl font-bold text-yellow-500">5</p>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow">
                <h3 class="text-gray-500 text-sm">Project Selesai</h3>
                <p class="text-2xl font-bold text-green-500">7</p>
            </div>

        </div>

        <!-- Tabel Project -->
        <div class="bg-white p-6 rounded-2xl shadow">
            <h3 class="text-lg font-semibold mb-4">Daftar Project</h3>

            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">Nama Project</th>
                        <th class="py-2">Divisi</th>
                        <th class="py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="py-2">Website Company Profile</td>
                        <td class="py-2">IT</td>
                        <td class="py-2 text-yellow-500">Ongoing</td>
                    </tr>

                    <tr class="border-b">
                        <td class="py-2">Desain Banner</td>
                        <td class="py-2">Desainer</td>
                        <td class="py-2 text-green-500">Selesai</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>