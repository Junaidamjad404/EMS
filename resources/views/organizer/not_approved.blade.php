<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="bg-white shadow-md rounded-lg p-6 max-w-md mx-auto">
                        <h1 class="text-xl font-semibold mb-4 text-center">{{ ('Pending Approval') }}</h1>
                        <p class="text-gray-700 mb-4 text-center">
                            You have not been approved by an admin yet. Please wait for approval before accessing event
                            management features.
                        </p>
                        @if (Auth::user()->active_organizer)
                            <div class="text-center">
                            <x-primary-button><a href="{{ route('events.index') }}">Return to Home</a></x-primary-button>
                        </div>
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>

</x-app-layout>
