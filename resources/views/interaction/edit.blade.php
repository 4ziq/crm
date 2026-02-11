<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Log Interaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> {{-- Reduced width for better readability on desktop --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-8 text-gray-900">

                    <form action="{{ route('interactions.update', $interaction->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <!-- Customer Selection -->
                        <div>
                            <x-input-label for="customer_id" :value="__('Customer')" />
                            <select name="customer_id" id="customer_id"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="" disabled selected>Select a customer...</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        {{ old('customer_id', $interaction->customer_id) == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('customer_id')" class="mt-2" />
                        </div>

                        <!-- Date and Type Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="interaction_date" :value="__('Date of Interaction')" />
                                <div class="relative mt-1">
                                    <!-- Icon Prefix (Breeze Style) -->
                                    <div
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>

                                    <x-text-input id="interaction_date" name="interaction_date" type="text"
                                        {{-- Change to text for Flatpickr --}} :value="$interaction->interaction_date" class="pl-10 block w-full"
                                        placeholder="Select date..." />
                                </div>
                                <x-input-error :messages="$errors->get('interaction_date')" class="mt-2" />
                            </div>


                            <div>
                                <x-input-label for="type" :value="__('Interaction Type')" />
                                <select name="type" id="type"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">

                                    @php $currentType =  $interaction->type; @endphp

                                    <option value="call" {{ $currentType == 'call' ? 'selected' : '' }}>Call</option>
                                    <option value="email" {{ $currentType == 'email' ? 'selected' : '' }}>Email
                                    </option>
                                    <option value="meeting" {{ $currentType == 'meeting' ? 'selected' : '' }}>Meeting
                                    </option>

                                </select>
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Notes Area -->
                        <div>
                            <div class="flex justify-between">
                                <x-input-label for="notes" :value="__('Notes')" />
                                <span class="text-xs text-gray-400">Optional</span>
                            </div>
                            <textarea name="notes" id="notes" rows="4" placeholder="Summarize the key points of the conversation..."
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('notes', $interaction->notes) }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('interactions.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Cancel') }}
                            </a>

                            <x-primary-button>
                                {{ __('Save Interaction') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Flatpickr Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#interaction_date", {
                dateFormat: "Y-m-d", // Database format
                altInput: true, // Show user a friendly format
                altFormat: "F j, Y", // e.g. February 11, 2026
                allowInput: true,
                disableMobile: "true", // Force the better UI on mobile
            });
        });
    </script>
</x-app-layout>
