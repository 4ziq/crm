<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Customer Information') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Form to create a edit customer information --}}
                    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                        @csrf
                        @method('PUT') 
                        {{-- name --}}
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" value="{{ $customer->name }}" class="mt-1 block w-full mb-2"
                            autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        {{-- end name --}}

                        {{-- email --}}
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" value="{{ $customer->email }}" class="mt-1 block w-full mb-2"
                            autocomplete="email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        {{-- end email --}}

                        {{-- phone --}}
                        <x-input-label for="phone" :value="__('Phone (optional)')" />
                        <x-text-input id="phone" name="phone" type="text" value="{{ $customer->phone }}" class="mt-1 block w-full mb-2"
                            autocomplete="phone" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        {{-- end phone --}}

                        {{-- address --}}
                        <div class="mb-4">
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <textarea name="address" id="address" rows=3
                                class="mt-1 mb-2 block w-full border border-gray-300 rounded-md shadow-sm p-2">{{ old('address', $customer->address) }}</textarea>
                        </div>
                        {{-- end address --}}

                        {{-- notes --}}
                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea name="notes" id="notes" rows=3
                                class="mt-1 mb-2 block w-full border border-gray-300 rounded-md shadow-sm p-2">{{ old('notes', $customer->notes) }}</textarea>
                        </div>
                        {{-- end notes --}}

                        <div class="flex items-center justify-between pt-4">
                            <a href="{{ route('customers.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                                ← Back to Customers
                            </a>

                            <x-primary-button>
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
