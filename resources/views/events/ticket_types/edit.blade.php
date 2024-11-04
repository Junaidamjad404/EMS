<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Ticket Type for Event: ') }} {{ $event->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <form method="POST" action="{{  route('ticket_types.update', ['event' => $event->id, 'ticket_type' => $eventTicketType->id]) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="event_id" value="{{ $event->id }}">

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Ticket Name') }}</label>
                        <input type="text" name="name" id="name" required
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('name', $eventTicketType->name) }}">
                        @error('name')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700">{{ __('Price') }}</label>
                        <input type="number" name="price" id="price" required step="0.01"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('price', $eventTicketType->pivot->price ) }}">
                        @error('price')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="benefits" class="block text-sm font-medium text-gray-700">{{ __('Benefits') }}</label>
                        <textarea name="benefits" id="benefits" rows="4" required
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('benefits', $eventTicketType->benefits) }}</textarea>
                        @error('benefits')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="quantity" class="block text-sm font-medium text-gray-700">{{ __('Quantity') }}</label>
                        <input type="number" name="quantity" id="quantity" required
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('quantity', $eventTicketType->pivot->quantity ) }}">
                        @error('quantity')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button type="submit">
                            {{ __('Update Ticket Type') }}
                        </x-primary-button>
                         <x-secondary-button
                                class="mx-2"    onclick="window.history.back()">{{ __('Back') }}</x-secondary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
