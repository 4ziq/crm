<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Interaction History') }}
            </h2>
            <a href="{{ route('interactions.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4""" ) />>
                </svg>
                {{ __('Log Interaction') }}
            </a>
        </div>
    </x-slot>

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
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Customer</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Date</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Type</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Notes</th>
                                <th scope="col" class="relative px-6 py-4">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($interactions as $interaction)
                                <tr class="hover:bg-gray-50/80 transition-colors duration-150 group">
                                    <!-- Customer -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $interaction->customer->name }}</div>
                                    </td>

                                    <!-- Date -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600">
                                            {{ \Carbon\Carbon::parse($interaction->interaction_date)->format('M d, Y') }}
                                        </div>
                                    </td>

                                    <!-- Type -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $badgeClasses = match ($interaction->type) {
                                                'call' => 'bg-blue-50 text-blue-700 border-blue-100',
                                                'email' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                                'meeting' => 'bg-violet-50 text-violet-700 border-violet-100',
                                                default => 'bg-gray-50 text-gray-600 border-gray-100',
                                            };
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $badgeClasses }}">
                                            {{ $interaction->type }}
                                        </span>
                                    </td>

                                    <!-- Notes -->
                                    <td class="px-6 py-4 text-sm text-gray-500 max-w-xs">
                                        <p class="truncate" title="{{ $interaction->notes }}">
                                            {{ $interaction->notes ?: '—' }}
                                        </p>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end items-center space-x-4">

                                            {{-- edit --}}
                                            <a href="{{ route('interactions.edit', $interaction) }}"
                                                class="text-indigo-600 hover:text-indigo-900 transition-colors">Edit</a>

                                            {{-- delete --}}
                                            <button type="button" x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'confirm-delete-{{ $interaction->id }}')"
                                                class="text-gray-400 hover:text-red-600 transition-colors">
                                                Delete
                                            </button>

                                            <!-- Delete Modal -->
                                            <x-modal name="confirm-delete-{{ $interaction->id }}" focusable>
                                                <div class="p-6 text-left">
                                                    <form method="POST"
                                                        action="{{ route('interactions.destroy', $interaction) }}">
                                                        @csrf @method('DELETE')
                                                        <h2 class="text-lg font-semibold text-gray-900">Delete Interaction
                                                        </h2>
                                                        <p class="mt-2 text-sm text-gray-600">
                                                            Are you sure you want to delete
                                                            <strong>{{ $interaction->customer->name }}</strong>?
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
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500 italic">
                                        {{ __('No interactions logged yet.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($interactions->hasPages())
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                        {{ $interactions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
