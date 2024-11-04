<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Ticket Types for Event: ') }} {{ $event->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="items-center p-4 mb-4 text-sm text-green-700 bg-green-300 rounded-lg" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Create New Ticket Button -->
            @if (Auth::user()->hasPermission('create ticket type'))
                <div class="flex justify-between items-center text-lg font-medium text-gray-900"> 
                    <h2 class="text-lg font-medium text-gray-900">{{ __('Ticket Types') }}</h2>
                    <a href="{{ route('ticket_types.create', $event->id) }}">
                        <x-primary-button>{{ __('Create New Ticket Type') }}</x-primary-button>
                    </a>
                </div>
            @endif

            <!-- Ticket Types Table -->
            <div class="overflow-hidden shadow-md sm:rounded-lg mt-4">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ticket Name
                                </th>
                                <th scope="col"
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price ($)
                                </th>
                                <th scope="col"
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Benefits
                                </th>
                                <th scope="col"
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Quantity
                                </th>
                                <th scope="col"
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Sell
                                </th>
                                <th scope="col"
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($ticketTypes as $ticketType)
                                <tr>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                        {{ $ticketType->name }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                        {{ $ticketType->pivot->price }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                        {{ $ticketType->benefits }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                        {{ $ticketType->pivot->quantity }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                        {{ $ticketType->ticketPurchases->where('event_id',$event->id)->count() }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium">
                                        <!-- Edit Ticket Type -->
                                        <a href="{{ route('ticket_types.edit', [$event->id, $ticketType->id]) }}"
                                            class="inline-flex items-center text-indigo-600 hover:text-indigo-900">
                                            <svg class="h-6 w-6 " fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14.121 4.121a3 3 0 00-4.242 0L3 11.586V17h5.414l6.879-6.879a3 3 0 000-4.242z" />
                                            </svg>
                                        </a>

                                        <!-- Delete Ticket Type -->
                                        <form
                                            action="{{ route('ticket_types.destroy', [$event->id, $ticketType->id]) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center text-red-600 hover:text-red-900"
                                                onclick="return confirm('Are you sure you want to delete this ticket type?');">
                                                <svg class="h-7 w-6 mr-2" fill="none" stroke="currentColor"
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
            <div class="flex justify-between items-center mb-4">
                <a href="{{ route('events.index') }}">
                    <x-secondary-button>{{ __('Back to Events') }}</x-secondary-button>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
