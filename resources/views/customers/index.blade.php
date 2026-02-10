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
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No</th>
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
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $customer->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <a href="#" class="text-red-600 hover:text-red-900 pl-2">Delete</a>
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
