<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Events') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-4 lg:2x-8 space-y-6">
            <div class="container mx-auto py-8">
                <!-- Hero Section -->
                <div class="relative rounded-lg shadow-lg overflow-hidden">
                    @if ($event->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $event->images->first()->image_url) }}" alt="{{ $event->title }}"
                            class="w-full h-96 object-cover">
                    @else
                        
                        <p class="text-center mt-2 text-2xl font-bold ">No promotional image available for this event.</p>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
                    <div class="relative p-6 text-white">
                        <h1 class="text-4xl font-bold">{{ $event->title }}</h1>
                        <p class="mt-2 text-lg">{{ $event->location }}</p>
                        <p class="mt-2 text-xl">{{ \Carbon\Carbon::parse($event->date)->format('F j, Y') }}</p>
                        <p class="mt-2 text-2xl font-bold">{{ \Carbon\Carbon::parse($event->date)->diffForHumans() }}
                            left!</p>
                        <a href="{{ route('events.show', $event->id) }}"
                            class="inline-block mt-4 px-4 py-2 bg-green-600 hover:bg-green-700 rounded-md shadow">
                            RSVP Now
                        </a>
                    </div>
                </div>

                <!-- Event Description -->
                <div class="mt-8">
                    <h2 class="text-lg font-medium text-gray-900">{{ __('Event Details') }}</h2>
                    <p class="mt-2 text-gray-700">{{ $event->description }}</p>
                </div>

                <!-- Schedule Section -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Event Details') }}</h3>
                    <div class="mt-2 ">
                        <p><strong>{{ __('Date:') }}</strong>
                            {{ \Carbon\Carbon::parse($event->date)->format('l, F j, Y') }}</p>
                        <p><strong>{{ __('Time:') }}</strong>
                            {{ \Carbon\Carbon::parse($event->date)->format('g:i A') }}</p>
                        <p><strong>{{ __('Location:') }}</strong> {{ $event->location }}</p>
                        <p><strong>{{ __('Category:') }}</strong> {{ $event->category->name }}</p>
                        {{-- Ensure this relationship exists --}}
                        <p><strong>{{ __('Status:') }}</strong> {{ $event->status }}</p>
                    </div>
                </div>

                <!-- Location Section -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Location') }}</h3>
                    <div class="mb-4 mt-2">
                        <iframe src="https://maps.google.com/maps?q={{ urlencode($event->location) }}&output=embed"
                            class="w-full h-60" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>

                <!-- Feedback and Social Share Section -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Join the Conversation') }}</h3>
                    <div class="mt-2">
                        <label for="comments" class="block text-gray-700">Leave a comment:</label>
                        <textarea id="comments" rows="4" class="w-full border rounded-md p-2 mt-1" placeholder="Share your thoughts..."></textarea>
                        <x-primary-button>Submit </x-primary-button>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('Share This Event') }}</h3>
                        <div class="flex space-x-4 mt-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                                target="_blank" class="flex items-center text-blue-600 hover:text-blue-800">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="h-5 w-5 mr-2">
                                    <path fill="#3b5998"
                                        d="M80 299.3V512H196V299.3h86.5l18-97.8H196V166.9c0-51.7 20.3-71.5 72.7-71.5c16.3 0 29.4 .4 37 1.2V7.9C291.4 4 256.4 0 236.2 0C129.3 0 80 50.5 80 159.4v42.1H14v97.8H80z" />
                                </svg>

                            </a>

                            <!-- Twitter Share -->
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($event->title) }}&url={{ urlencode(request()->fullUrl()) }}"
                                target="_blank" class="flex items-center text-blue-400 hover:text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="h-5 w-5 mr-2">
                                    <path fill="#1DA1F2"
                                        d="M162.3 391.8c-38.1 0-74.1-11.7-104.2-31.7 5.3.6 10.5.8 15.8.8 30.5 0 58.6-10.4 80.8-27.9-28.5-.5-52.5-19.4-60.8-45.4 4 0 .8 0 1.2.1 6.3 0 12.5-.9 18.5-2.5-29.9-6.5-52.4-32.4-52.4-64.1 8.8 4.9 18.7 7.9 29.4 8.2-17.5-11.7-29-31.6-29-54.1 0-24.7 12.3-46.4 31.2-59.2 23.4 28.8 57.7 47.5 96.3 49.5-1.6-9.9-2.4-19.9-2.4-30.1 0-72.9 59.2-132.2 132.2-132.2 38.2 0 72.7 16.1 97.4 41.8 30.4-6 58.8-16.9 83.7-31.7-10 30.9-31.1 56.7-58.5 73.3 27-3.2 52.7-10.5 76.3-21.1-18.1 27.7-40.8 52.1-66.8 71.3-15.5 11.1-35.2 18.4-56 21.2 38.4-24.3 67.9-60.7 81.4-103.1 24-11.4 44.3-27 60.7-44.6-24.8 11-51.6 18.5-79.2 21.8z" />
                                </svg>

                            </a>

                            <!-- LinkedIn Share -->
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}"
                                target="_blank" class="flex items-center text-blue-700 hover:text-blue-900">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-5 w-5 mr-2">
                                    <path fill="#0077B5"
                                        d="M100.28 448H7.4V149.32h92.88zM53.84 112.03C24.1 112.03 0 87.73 0 56.33 0 24.93 24.1 0 53.84 0 83.58 0 108 24.93 108 56.33c0 31.4-24.4 55.7-54.16 55.7zM447.9 448h-92.89V302.4c0-34.6-12.33-58.2-43.36-58.2-23.68 0-37.72 15.93-43.96 31.25-2.26 5.51-2.86 13.15-2.86 20.83V448h-92.89s1.24-255.68 0-282.68h92.89v40.09c-1.1 1.68-2.57 3.39-4.15 5.05 14.67-22.63 40.37-54.94 98.84-54.94 72.09 0 126.24 47.06 126.24 148.66V448z" />
                                </svg>

                            </a>

                            <!-- Instagram Share -->
                            <a href="https://www.instagram.com/" target="_blank"
                                class="flex items-center text-pink-600 hover:text-pink-800">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-5 w-5 mr-2">
                                    <path fill="#E1306C"
                                        d="M224.1 24c-63.6 0-117.4 51.3-117.4 115.6v74.8c0 64.3 53.8 115.6 117.4 115.6s117.4-51.3 117.4-115.6v-74.8C341.5 75.3 287.7 24 224.1 24zM256 217.7c0 17.6-14.3 31.9-31.9 31.9s-31.9-14.3-31.9-31.9 14.3-31.9 31.9-31.9 31.9 14.3 31.9 31.9zM320 155.6c0 10.7-8.7 19.4-19.4 19.4s-19.4-8.7-19.4-19.4 8.7-19.4 19.4-19.4S320 144.9 320 155.6zM400 250.5c0 67.7-55 122.6-122.6 122.6H170.6c-67.7 0-122.6-55-122.6-122.6V170.6C48 102.9 102.9 48 170.6 48h106.8C344.7 48 400 102.9 400 170.6v79.9z" />
                                </svg>

                            </a>
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($event->title . ' ' . request()->fullUrl()) }}"
                                target="_blank" class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="h-5 w-5 mr-2">
                                    <path
                                        d="M256 0C114.6 0 0 114.6 0 256c0 45.25 12.54 87.85 34.28 124.73l-22.05 81.4c-3.055 11.65 7.557 20.75 17.98 16.42l85.96-35.66C159.8 462.9 206.5 480 256 480c141.4 0 256-114.6 256-256S397.4 0 256 0zm97.5 371.4c-10.8 0-21.5-3.22-30.3-9.3l-32.9-21.8c-15.5 7.2-32.5 10.8-50.7 10.8-32.8 0-63.7-12.7-87.1-35.5-26.6-25.3-43.5-61.7-43.5-99.4 0-33.2 12.4-64.2 34.9-87.3 24.2-24.2 55.5-37.2 88.4-37.2 10.8 0 21.5 1.5 31.8 4.3 5.5 1.5 10.7 4.7 14.8 8.9 4.2 4.2 7.2 9.3 8.7 14.8 6.2 26.1 2.5 59.1-10.1 83.6l-24.8 38.6c-3.5 5.5-8.1 9.8-13.4 12.6-4.6 2.5-10.6 3.7-15.9 3.7z"
                                        fill="#25D366" />
                                </svg>

                            </a>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
    </div>
</x-app-layout>
