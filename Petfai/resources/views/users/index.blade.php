<x-app-layout>
    <div class="p-6 max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Manage Users</h1>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <table class="w-full border-collapse mb-8">
            <thead>
                <tr class="border-b text-left">
                    <th class="p-2">Name</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Role</th>
                    <th class="p-2">Status</th>
                    <th class="p-2"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-b">
                        <td class="p-2">{{ $user->name }}</td>
                        <td class="p-2">{{ $user->email }}</td>
                        <td class="p-2">{{ $user->role }}</td>
                        <td class="p-2">
                            <span class="{{ $user->is_active ? 'text-green-600' : 'text-red-600' }}">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="p-2">
                            <form method="POST" action="{{ route('users.toggleActive', $user) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-sm text-blue-600 underline">
                                    {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2 class="text-lg font-bold mb-3">Add New User</h2>
        <form method="POST" action="{{ route('users.store') }}" class="grid grid-cols-2 gap-3 max-w-md">
            @csrf
            <input type="text" name="name" placeholder="Name" class="border rounded px-3 py-2 col-span-2" required>
            <input type="email" name="email" placeholder="Email" class="border rounded px-3 py-2 col-span-2" required>
            <input type="password" name="password" placeholder="Password" class="border rounded px-3 py-2 col-span-2" required>
            <select name="role" class="border rounded px-3 py-2 col-span-2">
                <option value="sales">Sales</option>
                <option value="manager">Manager</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded col-span-2">Add User</button>
        </form>
    </div>
</x-app-layout>