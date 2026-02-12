<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-8 text-gray-900">

                    <div class="flex items-center pb-2 border-b border-gray-100">
                        <h3 class="text-sm font-bold uppercase tracking-widest text-gray-600">
                            {{ __('Edit User') }}
                        </h3>
                    </div>

                    <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Full Name')" />
                            <x-text-input id="name" name="name" type="text" :value="old('name', $user->name)"
                                class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Email Address')" />
                            <x-text-input id="email" name="email" type="email" :value="old('email', $user->email)"
                                class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Optional Password Change -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="password" :value="__('New Password')" />
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"
                                    placeholder="Leave blank to keep current password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                                    class="mt-1 block w-full" />
                            </div>
                        </div>

                        <!-- Roles -->
                        <div>
                            <div class="flex justify-between">
                                <x-input-label :value="__('Assign Roles')" />
                                <span class="text-xs text-gray-400">Required</span>
                            </div>

                            <div class="mt-3 grid grid-cols-1 md:grid-cols-3 gap-4">
                                @foreach ($roles as $role)
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                            {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                                        <span class="text-sm text-gray-700">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>

                            <x-input-error :messages="$errors->get('roles')" class="mt-2" />
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('users.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition">
                                {{ __('Cancel') }}
                            </a>

                            <x-primary-button>
                                {{ __('Update User') }}
                            </x-primary-button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
