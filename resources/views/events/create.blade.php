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
                                {{ __('Create Event') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Please fill in the details below to create a new event.') }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('events.store') }}" enctype="multipart/form-data"
                            class="mt-6 space-y-6">
                            @csrf

                            <div>
                                <x-input-label for="title" :value="__('Event Name')" />
                                <x-text-input id="title" name="title" type="text" required
                                    class="mt-1 block w-full" placeholder="Enter event name"
                                    value="{{ old('title') }}" />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="location" :value="__('Location')" />
                                <x-text-input id="location" name="location" type="text" required
                                    class="mt-1 block w-full" placeholder="Enter event location"
                                    value="{{ old('location') }}" />
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="date" :value="__('Date and Time')" />
                                <x-text-input id="date" name="date" type="datetime-local" required
                                    class="mt-1 block w-full" value="{{ old('date') }}" />
                                <x-input-error :messages="$errors->get('date')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="organizer" :value="__('Organizer')" />
                                <input type="text" value="{{ Auth::user()->name }}" readonly
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 cursor-not-allowed" />
                                <input type="hidden" name="organizer_id" value="{{ Auth::user()->id }}" />
                                <!-- Hidden field for storing organizer ID -->
                            </div>

                            <div>
                                <x-input-label for="category_id" :value="__('Event Category')" />
                                <select name="category_id" id="category_id" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="description" :value="__('Description')" />
                                <textarea id="description" name="description" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                    rows="4" placeholder="Enter event description" value="{{ old('description') }}">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="promotional_images" :value="__('Promotional Images')" />
                                <input id="promotional_images" name="promotional_images[]" type="file" multiple
                                    class="mt-1 block w-full " onchange="previewImages(event)">
                                @if ($errors->has('promotional_images.*'))
                                    @foreach ($errors->get('promotional_images.*') as $message)
                                        <div class="mt-2 text-red-600">{{ $message[0] }}</div>
                                        <!-- Displaying the first message -->
                                    @endforeach
                                @endif <small class="text-sm text-gray-600">You can upload multiple
                                    images.</small>

                            </div>

                            <!-- Image Preview Section -->
                            <div id="image-preview" class="mt-4 grid grid-cols-2 gap-4"></div>

                            <!-- Promotional Videos Upload -->
                            <div>
                                <x-input-label for="promotional_videos" :value="__('Promotional Videos')" />
                                <input id="promotional_videos" name="promotional_videos[]" type="file" multiple
                                    accept="video/*" class="mt-1 block w-full " onchange="previewVideos(event)">

                                <!-- Display validation errors for promotional_videos -->
                                @if ($errors->has('promotional_videos.*'))
                                    @foreach ($errors->get('promotional_videos.*') as $message)
                                        <div class="mt-2 text-red-600">{{ $message[0] }}</div>
                                        <!-- Displaying the first message -->
                                    @endforeach
                                @endif <small class="text-sm text-gray-600">You can upload multiple
                                    videos (MP4, AVI,
                                    etc.).</small>
                            </div>

                            <!-- Video Preview Section -->
                            <div id="video-preview" class="mt-4 grid grid-cols-2 gap-2"></div>



                            <div class="flex items-center gap-4">
                                <!-- Create Event Button -->
                                <x-primary-button>{{ __('Create Event') }}</x-primary-button>
                                <a href="{{ route('events.index') }}">
                                    <!-- Back Button -->
                                    <x-secondary-button>{{ __('Back') }}</x-secondary-button>
                                </a>
                            </div>

                            <!-- Flash Message: Event Created -->
                            @if (session('status') === 'event-created')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600 mt-2">
                                    {{ __('Event created successfully.') }}
                                </p>
                            @endif
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
    </script>
</x-app-layout>
