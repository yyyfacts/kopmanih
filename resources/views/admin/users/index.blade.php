<div class="max-w-4xl mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">Daftar Pengguna</h1>
    <div class="overflow-x-auto rounded-lg shadow">
        <table class="min-w-full bg-white dark:bg-gray-900">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">ID</th>
                    <th class="py-3 px-4 text-left">Nama</th>
                    <th class="py-3 px-4 text-left">Email</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 dark:text-gray-200">
                @foreach($users as $user)
                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-blue-50 dark:hover:bg-gray-800 transition">
                    <td class="py-2 px-4">{{ $user->id }}</td>
                    <td class="py-2 px-4">{{ $user->name }}</td>
                    <td class="py-2 px-4">{{ $user->email }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
