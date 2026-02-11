<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ticket #{{ $ticket->id }} Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-8 space-y-8">

                    <!-- Header Info -->
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">
                                {{ $ticket->title ?? 'No Title' }}
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Created on {{ $ticket->created_at->format('M d, Y') }}
                            </p>
                        </div>

                        <!-- Status & Priority Badges -->
                        <div class="flex gap-3">
                            @php
                                $statusClasses = match ($ticket->status) {
                                    'open' => 'bg-red-50 text-red-700 border-red-100',
                                    'in progress' => 'bg-yellow-50 text-yellow-700 border-yellow-100',
                                    'resolved' => 'bg-green-50 text-green-700 border-green-100',
                                    'closed' => 'bg-gray-50 text-gray-600 border-gray-100',
                                    default => 'bg-gray-50 text-gray-600 border-gray-100',
                                };

                                $priorityClasses = match ($ticket->priority) {
                                    'low' => 'bg-green-50 text-green-700 border-green-100',
                                    'medium' => 'bg-yellow-50 text-yellow-700 border-yellow-100',
                                    'high' => 'bg-red-50 text-red-700 border-red-100',
                                    default => 'bg-gray-50 text-gray-600 border-gray-100',
                                };
                            @endphp

                            <span class="px-3 py-1 text-xs font-medium rounded-full border {{ $statusClasses }}">
                                {{ ucfirst($ticket->status) }}
                            </span>

                            <span class="px-3 py-1 text-xs font-medium rounded-full border {{ $priorityClasses }}">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-100"></div>

                    <!-- Ticket Information Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        <!-- Customer Info -->
                        <div>
                            <h4 class="text-sm font-semibold uppercase tracking-widest text-gray-500 mb-2">
                                Customer Information
                            </h4>
                            <p class="text-gray-900 font-medium">
                                {{ $ticket->customer->name }}
                            </p>
                            <p class="text-sm text-gray-600">
                                {{ $ticket->customer->email }}
                            </p>
                            <p class="text-sm text-gray-600">
                                {{ $ticket->customer->phone }}
                            </p>
                        </div>

                        <!-- Assignment Info -->
                        <div>
                            <h4 class="text-sm font-semibold uppercase tracking-widest text-gray-500 mb-2">
                                Assignment
                            </h4>
                            <p class="text-gray-900 font-medium">
                                {{ $ticket->assignedTo->name ?? 'Unassigned' }}
                            </p>
                        </div>

                    </div>

                    <!-- Description Section -->
                    <div>
                        <h4 class="text-sm font-semibold uppercase tracking-widest text-gray-500 mb-3">
                            Description
                        </h4>
                        <div class="bg-gray-50 rounded-lg p-6 text-gray-700 leading-relaxed">
                            {{ $ticket->description ?? 'No description provided.' }}
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="flex justify-end gap-4 pt-6 border-t border-gray-100">

                        <a href="{{ route('tickets.index') }}"
                            class="px-4 py-2 bg-gray-200 text-gray-700 text-sm rounded-lg hover:bg-gray-300">
                            Back
                        </a>

                        <a href="{{ route('tickets.edit', $ticket) }}"
                            class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700">
                            Edit Ticket
                        </a>

                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
