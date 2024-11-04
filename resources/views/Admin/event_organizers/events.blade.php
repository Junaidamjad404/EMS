<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Events for: ') }} {{ $eventOrganizer->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-8 space-y-6">

            @if (session('success'))
                <div id="success-alert" class="items-center p-4 mb-4 text-sm text-green-700 bg-green-300 rounded-lg"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Tabs for Status -->
            <div class="flex space-x-4 mb-4">
                @foreach (['all', 'pending', 'approved', 'completed', 'cancelled'] as $status)
                    <a href="#"
                        class="status-tab px-4 py-2 text-sm font-medium text-center text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300 {{ request('status') === $status ? 'bg-blue-500 text-white' : '' }}"
                        data-status="{{ $status }}" data-organizer-id="{{ $eventOrganizer->id }}">
                        {{ ucfirst($status) }}
                    </a>
                @endforeach
            </div>

            <!-- Event Cards -->
            <div id="event-cards" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($events as $event)
                    <div class="event-card bg-white shadow-md rounded-lg overflow-hidden"
                        data-status="{{ $event->status }}">
                        <a href="{{ route('events.show', $event->id) }}">
                            @if ($event->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $event->images->first()->image_url) }}"
                                    alt="{{ $event->title }}" class="w-full h-40 object-cover">
                            @else
                                <p class="text-center mt-2 text-2xl font-bold">No image</p>
                            @endif
                        </a>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $event->title }}</h3>
                            <p class="text-gray-600 font-semibold text-sm mt-2">
                                Location: {{ $event->location }}
                            </p>
                            <form action="{{ route('events.updateEventStatus', $event->id) }}" method="POST"
                                class="inline mt-4">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="border rounded-md  p-3">
                                    <option value="pending" {{ $event->status == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="cancelled" {{ $event->status == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                    <option value="completed" {{ $event->status == 'completed' ? 'selected' : '' }}>
                                        Completed</option>
                                    <option value="approved" {{ $event->status == 'approved' ? 'selected' : '' }}>
                                        Approved
                                    </option>
                                </select>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="flex items-center gap-4">


                <!-- Back Button -->
                <x-secondary-button
    onclick="window.location.href='{{ route('admin.index') }}'">
    {{ __('Back') }}
</x-secondary-button>

            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.status-tab').on('click', function(e) {
            e.preventDefault(); // Prevent default link behavior

            var status = $(this).data('status');
            var eventOrganizerId = $(this).data('organizer-id');

            // Perform AJAX request
            $.ajax({
                url: '{{ route('events.listEventsByStatus', ['eventOrganizerId' => ':eventOrganizerId']) }}'
                    .replace(':eventOrganizerId', eventOrganizerId),
                method: 'GET',
                data: {
                    status: status
                },
                success: function(data) {
                    $('#event-cards').html(data); // Replace event cards with the new HTML
                },
                error: function(xhr) {
                    console.error('Error fetching events:', xhr);
                }
            });
        });
    });
</script>
