<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto px-6 space-y-6">

            <h1 class="text-2xl font-bold text-gray-900">Manage Users</h1>

            @if (session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="font-semibold text-gray-800 mb-4">All Users</h3>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 border-b">
                            <th class="py-2">Name</th>
                            <th class="py-2">Email</th>
                            <th class="py-2">Role</th>
                            <th class="py-2">Status</th>
                            <th class="py-2 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-b last:border-0">
                                <td class="py-3">{{ $user->name }}</td>
                                <td class="py-3">{{ $user->email }}</td>
                                <td class="py-3 capitalize">{{ $user->role }}</td>
                                <td class="py-3">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="py-3 text-right">
                                    <form method="POST" action="{{ route('users.toggleActive', $user) }}">
                                        @csrf
                                        @method('PATCH')
                                       <button type="submit" class="text-xs px-3 py-1.5 rounded-lg font-medium {{ $user->is_active ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
    {{ $user->is_active ? 'Deactivate' : 'Activate' }}
</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Add New User</h3>
                <form method="POST" action="{{ route('users.store') }}" class="grid grid-cols-2 gap-4 max-w-md">
                    @csrf
                    <input type="text" name="name" placeholder="Name" class="border border-gray-300 rounded-lg px-3 py-2 col-span-2 text-sm" required>
                    <input type="email" name="email" placeholder="Email" class="border border-gray-300 rounded-lg px-3 py-2 col-span-2 text-sm" required>
                    <input type="password" name="password" placeholder="Password" class="border border-gray-300 rounded-lg px-3 py-2 col-span-2 text-sm" required>
                    <select name="role" class="border border-gray-300 rounded-lg px-3 py-2 col-span-2 text-sm">
                        <option value="sales">Sales</option>
                        <option value="manager">Manager</option>
                        <option value="admin">Admin</option>
                    </select>
                    <button type="submit" class="bg-pink-600 text-white px-4 py-2 rounded-lg col-span-2 text-sm hover:bg-pink-700">Add User</button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>