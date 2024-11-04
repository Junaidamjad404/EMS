@extends('layouts.main') <!-- Assuming you're using a main layout -->

@section('content')
    <section class="space-top space-extra-bottom d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header text-center" style="background-color: #8c00ff;">
                            <h6 style="color: white;">Create Event</h6>
                        </div>
                        <div class="card-body">
                            <!-- Display Success/Error Messages -->


                            <form id="eventForm" action="{{ route('user.events.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="form-group mb-2">
                                    <label class="auth-label" for='title'>Title</label>
                                    <input type="text" name="title" id="title" class="form-control form-control-sm"
                                        placeholder="Enter event title">
                                </div>

                                <div class="form-group mb-2">
                                    <label class="auth-label" for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control form-control-sm" rows="4"
                                        placeholder="Enter event description"></textarea>
                                </div>

                                <div class="form-group mb-2">
                                    <label class="auth-label" for="date">Date</label>
                                    <input type="datetime-local" name="date" id="date"
                                        class="form-control form-control-sm">
                                </div>
                                <div class="form-group mb-2">
                                    <label class="auth-label" for="category_id">Event Category</label>
                                    <select name="category_id" id="category_id" 
                                        class="form-control form-control-sm">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="auth-label" for="location">Location</label>
                                    <input type="text" name="location" id="location"
                                        class="form-control form-control-sm" placeholder="Enter event location">
                                </div>

                                <div class="form-group mb-2">
                                    <label class="auth-label" for="address">Address</label>
                                    <input type="text" name="address" id="address" class="form-control form-control-sm"
                                        placeholder="Your address">
                                </div>

                                <!-- Promotional Images Upload -->
                                <div class="form-group mb-2">
                                    <label class="auth-label" for="promotional_images">Promotional Images</label>
                                    <input id="promotional_images" name="promotional_images[]" type="file" multiple
                                        accept="image/*" class="form-control form-control-sm"
                                        onchange="previewImages(event)">
                                    <small class="text-sm text-gray-600">You can upload multiple images.</small>
                                </div>

                                <!-- Image Preview Section -->
                                <div id="image-preview" class="mt-2 grid grid-cols-2 gap-4"></div>

                                <!-- Promotional Videos Upload -->
                                <div class="form-group mb-2">
                                    <label class="auth-label" for="promotional_videos">Promotional Videos</label>
                                    <input id="promotional_videos" name="promotional_videos[]" type="file" multiple
                                        accept="video/*" class="form-control " onchange="previewVideos(event)">
                                    <small class="text-sm text-gray-600">You can upload multiple videos (MP4, AVI,
                                        etc.).</small>
                                </div>

                                <!-- Video Preview Section -->
                                <div id="video-preview" class="mt-2 grid grid-cols-2 gap-2"></div>

                                <!-- Submit Button with Loading Spinner -->
                                <div class="text-center">
                                    <div class="d-flex justify-content-between mt-3">
                                        <a href="{{ route('user.index') }}" class="vs-btn btn-secondary btn-sm w-45">
                                            <i class="fas fa-arrow-left"></i> Back
                                        </a>

                                        <button type="submit" class="vs-btn btn-primary btn-lg w-45" id="submitButton">
                                            <span id="buttonText">Create</span>
                                            <div class="spinner-border text-primary ml-2 d-none" role="status"
                                                id="loadingSpinner">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </button>

                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div> <!-- End Row -->
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#eventForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Show loading spinner
                $('#submitButton').prop('disabled', true);
                $('#loadingSpinner').removeClass('d-none');

                // Get form data
                var formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'), // The route to submit to
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // Handle success response
                        var previewContainer = document.getElementById('image-preview');
            previewContainer.innerHTML = ''; // Clear previous previews
              var previewContainer = document.getElementById('video-preview');
            previewContainer.innerHTML = ''; // Clear previous previews
                        $('#alertContainer').html('<div class="alert alert-success">' +
                            response.message + '</div>');
                        $('#eventForm')[0].reset(); // Reset form
                    },
                    error: function(xhr) {
                        $('.text-danger').remove();
                        $('#alertContainer').html(''); // Clear general error alert

                        if ( xhr.responseJSON.errors) {
                            // Handle validation errors and display them below the form fields
                            $.each(xhr.responseJSON.errors, function(field, errors) {
                                const errorMessage = errors[
                                0]; // Get the first error message
                                $(`[name="${field}"]`).closest('.form-group').append(
                                    `<span class="text-danger">${errorMessage}</span>`
                                    );
                            });
                        } else {
                            // Handle general errors or messages
                            const errorHtml =
                                `<div class="alert alert-danger">${xhr.responseText || 'An unexpected error occurred.'}</div>`;
                            $('#alertContainer').html(errorHtml); // Display the alert
                        }
                    },
                    complete: function() {
                        // Hide loading spinner
                        $('#submitButton').prop('disabled', false);
                        $('#loadingSpinner').addClass('d-none');
                    }
                });
            });
        });


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
@endsection
