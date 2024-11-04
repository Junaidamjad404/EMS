<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Event Organizers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Edit Event Organizers') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Please fill in the details below to edit a new event.') }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('eventOrganizers.update', $organizer->id) }}"
                            class="mt-6 space-y-6">
                            @csrf
                            @method('PUT') <!-- Use PUT for update -->
                            <div>
                                <x-input-label for="name" :value="__('Organizer Name')" />
                                <x-text-input id="name" name="name" type="text" required
                                    class="mt-1 block w-full" placeholder="Enter organizer name"
                                    value="{{ old('name', $organizer->name) }}" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Organizer Email')" />
                                <x-text-input id="email" name="email" type="text" required
                                    class="mt-1 block w-full" placeholder="Enter organizer email"
                                    value="{{ old('email', $organizer->email) }}" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="active_organizer" :value="__('Status')" />
                                <select name="active_organizer" id="active_organizer" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="1"
                                        {{ old('active_organizer', $organizer->active_organizer) == 1 ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="0"
                                        {{ old('active_organizer', $organizer->active_organizer) == 0 ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                                <x-input-error :messages="$errors->get('active_organizer')" class="mt-2" />
                            </div>



                            <div class="flex items-center gap-4">
                                <!-- Create organizer Button -->
                                <x-primary-button>{{ __('Update organizer') }}</x-primary-button>
                                <a href="{{ route('events.index') }}">
                                    <!-- Back Button -->
                                    <x-secondary-button>{{ __('Back') }}</x-secondary-button>
                                </a>
                            </div>

                            <!-- Flash Message: organizer Created -->
                            @if (session('status') === 'organizer-created')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600 mt-2">
                                    {{ __('Organizer created successfully.') }}
                                </p>
                            @endif
                        </form>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
