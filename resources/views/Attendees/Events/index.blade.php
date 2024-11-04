@extends('layouts.main')

@section('content')
    <div class="container" style="margin-top: 8%">
        <form class="form-style3 ajax-contact">
            <div class="row justify-content-between gx-10">
                <div class="col-sm-auto form-group">
                    <input class="form-control" type="text" name="fname" id="eventName" placeholder="Event Name...">
                </div>
                <div class="col-sm-auto form-group">
                    <select class="form-control" name="category" id="category">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-auto form-group">
                    <input class="form-control" type="text" name="location" id="location" placeholder="Location...">
                </div>
                <div class="col-sm-auto form-group">
                    <select class="form-control" name="organizer" id="organizer">
                        <option value="">Select Organizer</option>
                        @foreach ($event_organizers as $event_organizer)
                            <option value="{{ $event_organizer->id }}">{{ $event_organizer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-auto form-group">
                    <input class="form-control" type="datetime-local" name="startDate" id="startDate">
                </div>
            </div>
        </form>
    </div>

    <div class="event-details space-top space-extra-bottom">
        <div class="container">

            <div class="tab-content" id="myTabContent">
                <div id="eventList" class="tab-pane fade show active" role="tabpanel">
                    @include('Attendees.Events.partials.event-list', ['events' => $events])
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            <div class="vs-pagination">
                                <a href="#" class="pagi-btn">Prev</a>
                                <ul>
                                    <li><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">...</a></li>
                                    <li><a href="#">16</a></li>
                                </ul>
                                <a href="#" class="pagi-btn">Next</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filters = ['eventName', 'category', 'location', 'organizer', 'startDate'];

            filters.forEach(filter => {
                const element = document.getElementById(filter);
                // Use 'input' event for text fields and 'change' for select fields
                element.addEventListener(filter === 'eventName' || filter === 'location' || filter ===
                    'startDate' ? 'input' : 'change', filterEvents);
            });

            function filterEvents() {
                const eventName = document.getElementById('eventName').value;
                const category = document.getElementById('category').value;
                const location = document.getElementById('location').value;
                const organizer = document.getElementById('organizer').value;
                const startDate = document.getElementById('startDate').value;


                // Send AJAX request
                fetch("{{ route('events.filter') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            eventName,
                            category,
                            location,
                            organizer,
                            startDate
                        })
                    })
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('eventList').innerHTML = html;
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    </script>
@endsection
