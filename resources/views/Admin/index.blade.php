<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-8 space-y-6">

            <!-- Notification Area -->



            <!-- Button to Redirect to Roles and Permissions -->
            <div class="flex justify-end mb-4">
                <a href="{{ route('roles.permissions.index') }}">
                    <x-primary-button>
                        {{ __('Manage Roles & Permissions') }}
                    </x-primary-button>
                </a>
            </div>

            <!-- Event Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <div class="bg-blue-500 text-white p-4 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Total Event Organizers:</h2>
                    <p class="text-2xl"> {{ $eventOrganizers->count() }}</p>
                </div>
                <div class="bg-green-500 text-white p-4 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Active Events Organizer</h2>
                    <p class="text-2xl"> {{ $activeEventOrganizers->count() }}</p>
                </div>
                <div class="bg-yellow-500 text-white p-4 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Inactive Events Organizer</h2>
                    <p class="text-2xl"> {{ $InactiveEventOrganizers->count() }}</p>
                </div>
            </div>

            <!-- Event Organizer Table -->
            <div class="overflow-hidden shadow-md sm:rounded-lg mt-4">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name</th>
                                <th scope="col"
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email</th>
                                <th scope="col"
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Event Organizer</th>
                                <th scope="col"
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Events</th>
                                <th scope="col"
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($eventOrganizers as $eventOrganizer)
                                <tr>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                        {{ $eventOrganizer->name }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                        {{ $eventOrganizer->email }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                        <form action="{{ route('eventOrganizers.status', $eventOrganizer->id) }}"
                                            method="GET" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="{{ $eventOrganizer->active_organizer == 1 ? 'text-red-600 hover:text-red-900' : 'text-indigo-600 hover:text-indigo-900' }}">
                                                <svg class="h-6 w-6 inline-block" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="{{ $eventOrganizer->active_organizer == 1 ? 'M12 8 l-6 6 M6 8 l6 6' : 'M15 12 H9 M15 12 l-6 6 M9 12 l6-6' }}" />
                                                </svg>
                                                {{ $eventOrganizer->active_organizer == 1 ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">

                                        <a href="{{ route('eventOrganizers.events', $eventOrganizer->id) }}"
                                            class="inline-flex items-center text-green-600 hover:text-green-900 mr-2">
                                            <svg class="h-4 w-6 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 30 16" xmlns="http://www.w3.org/2000/svg"
                                                style="position: relative; top: 1px;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 2C7 2 3 8 3 8s4 6 12 6 12-6 12-6-4-6-12-6zm0 4a3 3 0 110 6 3 3 0 010-6z" />
                                            </svg>
                                            {{ __('View Events') }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('eventOrganizers.edit', $eventOrganizer->id) }}"
                                            class="inline-flex items-center text-indigo-600 hover:text-indigo-900">
                                            <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14.121 4.121a3 3 0 00-4.242 0L3 11.586V17h5.414l6.879-6.879a3 3 0 000-4.242z">
                                                </path>
                                            </svg>
                                        </a>

                                        <form action="{{ route('eventOrganizers.destroy', $eventOrganizer->id) }}"
                                            method="POST" class="inline-flex items-center">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center text-red-600 hover:text-red-900"
                                                onclick="return confirm('Are you sure you want to delete this event organizer?');">
                                                <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
