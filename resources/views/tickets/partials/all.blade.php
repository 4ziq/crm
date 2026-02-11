<section>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Success Message Toast (Alpine.js) -->
            @if (session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition
                    class="mb-6 rounded-lg bg-emerald-50 p-4 border border-emerald-200 flex items-center shadow-sm">
                    <svg class="h-5 w-5 text-emerald-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd""") />>
                    </svg>
                    <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="overflow-x-auto">

                    <!-- Search & Filters -->
                    <form method="GET" action="{{ route('tickets.index') }}"
                        class="p-5 border-b border-gray-100 bg-gray-50/50">

                        <!-- Top Row -->
                        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">

                            <!-- LEFT: Filters -->
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 flex-1">

                                <!-- Search -->
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search ticket, customer..."
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">

                                <!-- Status -->
                                <select name="status"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                    <option value="">All Status</option>
                                    <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open
                                    </option>
                                    <option value="in progress"
                                        {{ request('status') == 'in progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>
                                        Resolved</option>
                                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed
                                    </option>
                                </select>

                                <!-- Priority -->
                                <select name="priority"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                    <option value="">All Priority</option>
                                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low
                                    </option>
                                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>
                                        Medium</option>
                                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High
                                    </option>
                                </select>

                                <!-- Assigned -->
                                <select name="assigned_to"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                    <option value="">All Assignees</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ request('assigned_to') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- RIGHT: Actions -->
                            <div class="flex items-center gap-3">

                                <!-- Filter -->
                                <button type="submit"
                                    class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700 shadow-sm">
                                    Filter
                                </button>

                                <!-- Reset -->
                                <a href="{{ route('tickets.index') }}"
                                    class="px-4 py-2 bg-gray-200 text-gray-700 text-sm rounded-lg hover:bg-gray-300">
                                    Reset
                                </a>

                                <!-- Divider -->
                                <div class="h-6 w-px bg-gray-300"></div>

                                <!-- Export Dropdown -->
                                <div x-data="{ open: false }" class="relative">
                                    <button type="button" @click="open = !open"
                                        class="px-4 py-2 bg-emerald-600 text-white text-sm rounded-lg hover:bg-emerald-700 shadow-sm flex items-center gap-2">
                                        Export
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <div x-show="open" @click.away="open = false" x-transition
                                        class="absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg border border-gray-100 z-50">

                                        <a href="{{ route('tickets.export.csv', request()->query()) }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                            Export CSV
                                        </a>

                                        <a href="{{ route('tickets.export.pdf', request()->query()) }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                            Export PDF
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Ticket ID</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Customer Name</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Title</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Description</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Priority</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Created</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Assign to</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($tickets as $ticket)
                                <tr onclick="window.location='{{ route('tickets.show', $ticket) }}'"
                                    class="hover:bg-gray-50/80 transition-colors duration-150 group">

                                    <!-- Ticket ID -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $ticket->id }}</div>
                                    </td>

                                    <!-- Customer -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $ticket->customer->name }}</div>
                                    </td>

                                    {{-- title --}}
                                    <td class="px-6 py-4 text-sm text-gray-500 max-w-xs">
                                        <p class="truncate" title="{{ $ticket->title }}">
                                            {{ $ticket->title ?: '—' }}
                                        </p>
                                    </td>

                                    <!-- Description -->
                                    <td class="px-6 py-4 text-sm text-gray-500 max-w-xs">
                                        <p class="truncate" title="{{ $ticket->description }}">
                                            {{ $ticket->description ?: '—' }}
                                        </p>
                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $badgeStatusClasses = match ($ticket->status) {
                                                'open' => 'bg-red-50 text-red-700 border-red-100',
                                                'in progress' => 'bg-yellow-50 text-yellow-700 border-yellow-100',
                                                'resolved' => 'bg-green-50 text-green-700 border-green-100',
                                                'closed' => 'bg-gray-50 text-gray-600 border-gray-100',
                                                default => 'bg-gray-50 text-gray-600 border-gray-100',
                                            };
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $badgeStatusClasses }}">
                                            {{ $ticket->status }}
                                        </span>
                                    </td>

                                    <!-- priority -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $badgePriorityClasses = match ($ticket->priority) {
                                                'low' => 'bg-green-50 text-green-700 border-green-100',
                                                'medium' => 'bg-yellow-50 text-yellow-700 border-yellow-100',
                                                'high' => 'bg-red-50 text-red-700 border-red-100',
                                                default => 'bg-gray-50 text-gray-600 border-gray-100',
                                            };
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $badgePriorityClasses }}">
                                            {{ $ticket->priority }}
                                        </span>
                                    </td>

                                    <!-- Date -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600">
                                            {{ \Carbon\Carbon::parse($ticket->created_at)->format('M d, Y') }}
                                        </div>
                                    </td>

                                    <!-- Assigned to -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600">
                                            {{ $ticket->assignedTo->name ?? 'Unassigned' }}
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    {{-- <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end items-center space-x-4">

                                            
                                            <a href="{{ route('tickets.edit', $ticket) }}"
                                                class="text-indigo-600 hover:text-indigo-900 transition-colors">Edit</a>

                                            
                                            <button type="button" x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'confirm-delete-{{ $ticket->id }}')"
                                                class="text-gray-400 hover:text-red-600 transition-colors">
                                                Delete
                                            </button>

                                            
                                            <x-modal name="confirm-delete-{{ $ticket->id }}" focusable>
                                                <div class="p-6 text-left">
                                                    <form method="POST"
                                                        action="{{ route('tickets.destroy', $ticket) }}">
                                                        @csrf @method('DELETE')
                                                        <h2 class="text-lg font-semibold text-gray-900">Delete
                                                            Ticket
                                                        </h2>
                                                        <p class="mt-2 text-sm text-gray-600">
                                                            Are you sure you want to delete
                                                            <strong>{{ $ticket->customer->name }}</strong>?
                                                            All associated tickets will also be removed.
                                                        </p>
                                                        <div class="mt-6 flex justify-end space-x-3">
                                                            <x-secondary-button
                                                                x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                                                            <x-danger-button>Delete Permanentely</x-danger-button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </x-modal>
                                        </div>
                                    </td> --}}
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500 italic">
                                        {{ __('No tickets logged yet.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($tickets->hasPages())
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                        {{ $tickets->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
