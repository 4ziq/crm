<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Users Management') }}
            </h2>

            <a href="{{ route('users.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('Add User') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 rounded-lg bg-emerald-50 p-4 border border-emerald-200">
                    <p class="text-sm font-medium text-emerald-800">
                        {{ session('success') }}
                    </p>
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100">
                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">
                                    Name
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">
                                    Email
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">
                                    Roles
                                </th>
                                <th class="relative px-6 py-4"></th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                        {{ $user->name }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $user->email }}
                                    </td>

                                    <td class="px-6 py-4 text-sm">
                                        @foreach ($user->roles as $role)
                                            <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded text-xs">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    </td>

                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <a href="{{ route('users.edit', $user->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900 mr-4">
                                            Edit
                                        </a>

                                        <form action="{{ route('users.destroy', $user) }}"
                                            method="POST"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="text-gray-400 hover:text-red-600">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4"
                                        class="px-6 py-12 text-center text-gray-500 italic">
                                        No users found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
