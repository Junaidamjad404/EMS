@extends('layouts.main')

@section('content')
    <!-- About Area Start -->
    @include('layouts.attendees.aboutUs')
    <!-- About Area End -->
    <!-- Service Area -->
    @include('layouts.attendees.service')
    <!-- Service Area End -->
    <!-- Counter Area Start -->
    @include('layouts.attendees.counter')
    <!-- Counter Area End -->

    <!-- Team Area -->
    @include('layouts.attendees.team')
    <!-- Team Area end -->

    <!-- Gallery Area Start -->
    <section class="events smoke-bg space-top space-bottom">
        <div class="container">
            <div class="row">
                <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-10 mx-auto">
                    <div class="title-area text-center">
                        <span class="sec-subtitle2">Upcoming Events</span>
                        <h2 class="sec-title">Explore Our Next Upcoming Awesome Events</h2>
                    </div>
                </div>
            </div>
            <div class="row vs-carousel events-slide2 wow fadeInUp" data-slide-show="1" data-center-mode="true"
                data-xl-center-mode="true" data-ml-center-mode="true" data-lg-center-mode="true" data-md-center-mode="true"
                data-center-padding="370px" data-xl-center-padding="370px" data-ml-center-padding="300px"
                data-lg-center-padding="200px" data-md-center-padding="80px">

                @foreach ($events as $event)
                    <div class="col-md-6 col-lg-4">
                        <div class="event-style2">
                            <div class="event-img">
                                <div class="overlay"></div>

                                @php
                                    // Get the first image URL or fallback to default
                                    $imageUrl = !empty($event->images->first()->image_url)
                                        ? $event->images->first()->image_url
                                        : 'assets/img/events/default.jpg'; // Fallback image
                                @endphp

                                <img class="img" src="{{ asset($imageUrl) }}" alt="{{ $event->title }}">
                                <div class="event-date">
                                    <span>{{ $event->date->format('d') }}</span>
                                    {{ $event->date->format('F') }}
                                </div>
                                <h3 class="event-title">
                                    <a href="{{ route('user.event.details', $event->id) }}">{{ $event->title }}</a>
                                </h3>
                            </div>

                            <div class="event-content">
                                <div class="event-meta">
                                    <ul>
                                        <li>
                                            <span><i class="fas fa-clock"></i>{{ $event->date->format('h:i A') }} -
                                                {{ $event->date->copy()->addHours(2)->format('h:i A') }}</span>
                                        </li>
                                        <li>
                                            <span><i class="fas fa-map-marker-alt"></i>{{ $event->location }}</span>
                                        </li>
                                    </ul>
                                </div>

                                <h3 class="event-title h5">
                                    <a href="{{ route('user.event.details', $event->id) }}">{{ $event->title }}</a>
                                </h3>

                                <p class="event-text">{{ \Illuminate\Support\Str::limit($event->description, 100) }}</p>

                                <div class="event-footer">
                                    <a href="{{ route('user.event.details', $event->id) }}" class="event-link">Tickets &
                                        Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    <!-- Blog Area -->
    @include('layouts.attendees.blog')
@endsection
