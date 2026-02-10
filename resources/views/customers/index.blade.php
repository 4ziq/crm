<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Success Message -->
                    @if (session('success'))
                        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
                            class="mb-6 rounded-md bg-green-50 p-4 border border-green-200">
                            <p class="text-sm font-medium text-green-800">
                                {{ session('success') }}
                            </p>
                        </div>
                    @endif
                    <div class="flex items-center justify-end mb-6">
                        <div>
                            <a href="{{ route('customers.create') }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                                + Add Customer
                            </a>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    {{-- <th
                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No</th> --}}
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action</th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name</th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email</th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Phone</th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Address</th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Notes</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($customers as $customer)
                                    <tr>
                                        {{-- <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td> --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{-- edit --}}
                                            <x-secondary-button>
                                                <a href="{{ route('customers.edit', $customer->id) }}"
                                                    class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            </x-secondary-button>

                                            <x-danger-button x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'confirm-delete-customer-{{ $customer->id }}')">{{ __('Delete') }}</x-danger-button>

                                            <x-modal name="confirm-delete-customer-{{ $customer->id }}" maxWidth="2xl"
                                                focusable>
                                                <div class="p-6">
                                                    <form method="POST"
                                                        action="{{ route('customers.destroy', $customer) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <h2 class="text-lg font-semibold text-gray-900">
                                                            Delete Customer
                                                        </h2>

                                                        <p class="mt-2 text-sm text-gray-600 word-break">
                                                            Are you sure you want to delete
                                                            <strong>{{ $customer->name }}</strong>?
                                                            This action cannot be undone.
                                                        </p>

                                                        <div class="mt-6 flex justify-end gap-3">
                                                            {{-- cancel --}}
                                                            <x-secondary-button x-on:click="$dispatch('close')">
                                                                {{ __('Cancel') }}
                                                            </x-secondary-button>
                                                            {{-- delete --}}
                                                            <x-danger-button class="ms-3">
                                                                {{ __('Delete Customer') }}
                                                            </x-danger-button>

                                                        </div>
                                                    </form>
                                                </div>
                                            </x-modal>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $customer->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $customer->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $customer->phone }}</td>
                                        <td class="px-6 py-4 whitespace-normal break-words">{{ $customer->address }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-normal break-words">{{ $customer->notes }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $customers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
