<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Customers') }}
            </h2>
            <a href="{{ route('customers.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('Add Customer') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Success Message Toast -->
            @if (session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition
                    class="mb-6 rounded-lg bg-emerald-50 p-4 border border-emerald-200 flex items-center shadow-sm">
                    <svg class="h-5 w-5 text-emerald-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="overflow-x-auto">
                    <!-- Search & Filters -->
                    <form method="GET" action="{{ route('customers.index') }}"
                        class="p-5 border-b border-gray-100 bg-gray-50/50">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

                            <!-- Search -->
                            <div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search ticket, customer..."
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            </div>

                            <!-- Buttons -->
                            <div class="flex space-x-2">
                                <button type="submit"
                                    class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700">
                                    Filter
                                </button>

                                <a href="{{ route('customers.index') }}"
                                    class="px-4 py-2 bg-gray-200 text-gray-700 text-sm rounded-lg hover:bg-gray-300">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Customer Name</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Contact Info</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Address</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Notes</th>
                                <th scope="col" class="relative px-6 py-4"><span class="sr-only">Actions</span></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($customers as $customer)
                                <tr class="hover:bg-gray-50/80 transition-colors duration-150 group">
                                    <!-- Name -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">{{ $customer->name }}</div>
                                    </td>

                                    <!-- Contact Info -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $customer->email }}</div>
                                        <div class="text-xs text-gray-500">{{ $customer->phone ?: 'No phone' }}</div>
                                    </td>

                                    <!-- Address -->
                                    <td class="px-6 py-4 text-sm text-gray-500 max-w-xs">
                                        <div class="truncate" title="{{ $customer->address }}">
                                            {{ $customer->address ?: '—' }}
                                        </div>
                                    </td>

                                    <!-- Notes -->
                                    <td class="px-6 py-4 text-sm text-gray-500 max-w-xs">
                                        <div class="truncate" title="{{ $customer->notes }}">
                                            {{ $customer->notes ?: '—' }}
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end items-center space-x-4">
                                            <a href="{{ route('customers.edit', $customer->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900 transition-colors">Edit</a>

                                            <button type="button" x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'confirm-delete-{{ $customer->id }}')"
                                                class="text-gray-400 hover:text-red-600 transition-colors">
                                                Delete
                                            </button>
                                        </div>

                                        <!-- Delete Modal -->
                                        <x-modal name="confirm-delete-{{ $customer->id }}" focusable>
                                            <div class="p-6 text-left">
                                                <form method="POST"
                                                    action="{{ route('customers.destroy', $customer) }}">
                                                    @csrf @method('DELETE')
                                                    <h2 class="text-lg font-semibold text-gray-900">Delete Customer</h2>
                                                    <p class="mt-2 text-sm text-gray-600">
                                                        Are you sure you want to delete
                                                        <strong>{{ $customer->name }}</strong>?
                                                        All associated interactions will also be removed.
                                                    </p>
                                                    <div class="mt-6 flex justify-end space-x-3">
                                                        <x-secondary-button
                                                            x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                                                        <x-danger-button>Delete Permanentely</x-danger-button>
                                                    </div>
                                                </form>
                                            </div>
                                        </x-modal>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500 italic">No customers
                                        found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($customers->hasPages())
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                        {{ $customers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
