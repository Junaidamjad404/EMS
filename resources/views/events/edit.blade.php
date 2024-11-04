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
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Edit Event') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Please fill in the details below to create a new event.') }}
                            </p>
                        </header>

                        <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-6">
                            @csrf
                            @method('PUT') <!-- Use PUT for update -->

                            <div>
                                <x-input-label for="title" :value="__('Event Name')" />
                                <x-text-input id="title" name="title" type="text"
                                    value="{{ old('title', $event->title) }}" required class="mt-1 block w-full"
                                    placeholder="Enter event name" />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="location" :value="__('Location')" />
                                <x-text-input id="location" name="location" type="text"
                                    value="{{ old('location', $event->location) }}" class="mt-1 block w-full"
                                    placeholder="Enter location" />
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="date" :value="__('Date and Time')" />
                                <x-text-input id="date" name="date" type="datetime-local"
                                    value="{{ old('date', $event->date->format('Y-m-d\TH:i')) }}" required
                                    class="mt-1 block w-full" />
                                <x-input-error :messages="$errors->get('date')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="organizer" :value="__('Event Organizer')" />
                                <x-text-input id="organizer" name="organizer" type="text"
                                    value="{{ $event->organizer->name }}" required readonly
                                    class="mt-1 block w-full bg-gray-100 cursor-not-allowed" />
                                <x-input-error :messages="$errors->get('organizer')" class="mt-2" />
                                <input type="hidden" name="organizer_id" value="{{ $event->organizer_id }}" />

                            </div>
                            <div>
                                <x-input-label for="category_id" :value="__('Event Category')" />
                                <select name="category_id" id="category_id" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="status" :value="__('Event Status')" />
                                <select name="status" id="status" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Status</option>
                                    <option value="completed" {{ old('status', $event->status) == 'completed' ? 'selected' : '' }}>
                                        Completed
                                    </option>
                                    <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled
                                    </option>
                                     <option value="approved" disabled {{ old('status', $event->status) == 'approved' ? 'selected' : '' }}>
                                        Approved
                                    </option>
                                    <option value="pending" disabled {{ old('status', $event->status) == 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>


                            <div>
                                <x-input-label for="description" :value="__('Description')" />
                                <textarea id="description" name="description" class="mt-1 block w-full" rows="3"
                                    placeholder="Enter event description">{{ old('description', $event->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>


                            <div>
                                <x-input-label for="promotional_images" :value="__('Promotional Images')" />
                                <input id="promotional_images" name="promotional_images[]" type="file" multiple
                                    class="mt-1 block w-full" onchange="previewImages(event)">
                                <div id="image-preview" class="mt-4 grid grid-cols-2 gap-4"></div>

                                @if ($errors->has('promotional_images.*'))
                                    @foreach ($errors->get('promotional_images.*') as $message)
                                        <div class="mt-2 text-red-600">{{ $message[0] }}</div>
                                        <!-- Displaying the first message -->
                                    @endforeach
                                @endif
                                <small class="text-sm text-gray-600">You can upload multiple
                                    images.</small>

                                @if ($event->images->isNotEmpty())
                                    <div class="mt-2">
                                        <x-input-label for="existing_images" :value="__('Existing Images')" />
                                        <div class="grid grid-cols-3 gap-4">
                                            @foreach ($event->images as $image)
                                                <div class="relative group">
                                                    <img src="{{ asset('storage/' . $image->image_url) }}"
                                                        alt="Promotional Image" class="w-full h-auto rounded-md">
                                                    <button
                                                        onclick="deleteImage({{ $event->id }},{{ $image->id }})"
                                                        type="button"
                                                        class="absolute top-2 right-2 text-red-600 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                        <!-- SVG for delete icon -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                    
                                                </div>
                                            @endforeach
                                            <input type="hidden" name="existing_image_ids"
                                                        value="{{ implode(',', $event->images->pluck('id')->toArray()) }}">

                                        </div>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-600">No promotional images available.</p>
                                @endif
                            </div>


                            <!-- Promotional Videos -->
                            <div>
                                <x-input-label for="promotional_videos" :value="__('Promotional Videos')" />
                                <input id="promotional_videos" name="promotional_videos[]" type="file" multiple
                                    accept="video/*" class="mt-1 block w-full "
                                    onchange="previewVideos(event)">
                                <div id="video-preview" class="mt-4 grid grid-cols-2 gap-2"></div>

                                <!-- Display validation errors for promotional_videos -->
                                @if ($errors->has('promotional_videos.*'))
                                    @foreach ($errors->get('promotional_videos.*') as $message)
                                        <div class="mt-2 text-red-600">{{ $message[0] }}</div>
                                        <!-- Displaying the first message -->
                                    @endforeach
                                @endif <small class="text-sm text-gray-600">You can upload
                                    multiple
                                    videos (MP4, AVI,
                                    etc.).</small>
                                @if ($event->videos->isNotEmpty())
                                    <div class="mt-2">
                                        <x-input-label for="existing_videos" :value="__('Existing Videos')" />
                                        <div class="grid grid-cols-2 gap-4">
                                            @foreach ($event->videos as $video)
                                                <div class="relative group">
                                                    <video width="100%" controls class="rounded-md">
                                                        <source src="{{ asset('storage/' . $video->video_url) }}"
                                                            type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                    <button
                                                        onclick="deleteVideo({{ $event->id }}, {{ $video->id }})"
                                                        type="button"
                                                        class="absolute top-2 right-2 text-red-600 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                        <!-- SVG for delete icon -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            @endforeach
                                            <input type="hidden" name="existing_video_ids" value="{{ implode(',', $event->videos->pluck('id')->toArray()) }}">

                                        </div>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-600">No promotional videos available.</p>
                                @endif
                            </div>



                            <div class="flex items-center gap-3">
                                <!-- Create Event Button -->
                                <x-primary-button>{{ __('Update Event') }}</x-primary-button>
                                <x-secondary-button
                                    onclick="window.history.back()">{{ __('Back') }}</x-secondary-button>
                            </div>


                        </form>
                    </section>

                </div>
            </div>
        </div>
    </div>
    <script>
        function previewImages(event) {
            var files = event.target.files;
            var previewContainer = document.getElementById('image-preview');
            previewContainer.innerHTML = ''; // Clear previous previews

            if (files) {
                Array.from(files).forEach(file => {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        var img = document.createElement('img');
                        img.setAttribute('src', e.target.result);
                        img.classList.add('w-full', 'h-auto', 'rounded-md', 'shadow-sm'); // Add styling
                        img.style.maxWidth = '250px';
                        img.style.marginTop = '10px';

                        var div = document.createElement('div');
                        div.appendChild(img);
                        previewContainer.appendChild(div);
                    };

                    reader.readAsDataURL(file);
                });
            }
        }

        function previewVideos(event) {
            var files = event.target.files;
            var previewContainer = document.getElementById('video-preview');
            previewContainer.innerHTML = ''; // Clear previous previews

            if (files) {
                Array.from(files).forEach(file => {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        var video = document.createElement('video');
                        video.setAttribute('src', e.target.result);
                        video.setAttribute('controls', 'controls'); // Enable video controls (play, pause, etc.)
                        video.classList.add('w-full', 'rounded-md', 'shadow-sm'); // Add styling
                        video.style.maxWidth = '300px';
                        video.style.marginTop = '20px';

                        var div = document.createElement('div');

                        div.appendChild(video);
                        previewContainer.appendChild(div);
                    };

                    reader.readAsDataURL(file);
                });
            }
        }

        function deleteImage(eventId, imageId) {
            if (confirm('Are you sure you want to delete this image?')) {
                fetch(`/events/${eventId}/images/${imageId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload(); // Reload the page to see changes
                        } else {
                            alert('Failed to delete image.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }

        function deleteVideo(eventId, videoId) {
            if (confirm('Are you sure you want to delete this video?')) {
                fetch(`/events/${eventId}/videos/${videoId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload(); // Reload the page to see changes
                        } else {
                            alert('Failed to delete video.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }
    </script>
</x-app-layout>
