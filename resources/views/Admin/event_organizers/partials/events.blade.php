@foreach ($events as $event)
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <a href="{{ route('events.show', $event->id) }}">
            @if ($event->images->isNotEmpty())
                <img src="{{ asset('storage/' . $event->images->first()->image_url) }}" alt="{{ $event->title }}"
                    class="w-full h-40 object-cover">
            @else
                <p class="text-center mt-2 text-2xl font-bold ">No image</p>
            @endif
        </a>
        <div class="p-4">
            <h3 class="text-lg font-semibold text-gray-900">{{ $event->title }}</h3>
            <p class="text-gray-600 font-semibold text-sm mt-2">
                Location: {{ $event->location }}
            </p>
            <form action="{{ route('events.updateEventStatus', $event->id) }}" method="POST" class="inline mt-4">
                @csrf
                @method('PATCH')
                <select name="status" onchange="this.form.submit()" class="border rounded-md  p-3">
                    <option value="pending" {{ $event->status == 'pending' ? 'selected' : '' }}>Pending
                    </option>
                    <option value="cancelled" {{ $event->status == 'cancelled' ? 'selected' : '' }}>
                        Cancelled</option>
                    <option value="completed" {{ $event->status == 'completed' ? 'selected' : '' }}>
                        Completed</option>
                    <option value="approved" {{ $event->status == 'approved' ? 'selected' : '' }}>Approved
                    </option>
                </select>
            </form>
        </div>
    </div>
@endforeach
