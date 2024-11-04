@extends('layouts.main')

@section('content')
    <!-- Service Area -->
    <section class="service space-top space-extra-bottom">
        <div class="container">
            <div class="row justify-content-between align-items-end">
                <div class="col-lg-6 mx-auto">
                    <div class="title-area text-center">
                        <span class="sec-subtitle2">Services</span>
                        <h2 class="sec-title">Get A New Experience With Eventino Services</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ( $categories as $key=> $category)
                        <div class="col-lg-3 col-md-6 mb-30">
                    <div class="service-style1">
                        <div class="overlay"></div>
                        <a href="service-details.html" class="service-plus">
                            <i class="far fa-plus"></i>
                        </a>
                        <div class="service-img">
                            <img src="{{ asset('assets/img/services/s-1-'.($key+1).'.jpg') }}" alt="service image">
                        </div>
                        <div class="service-content">
                            <h2 class="service-name"><a href="service-details.html">{{ $category->name }}</a></h2>
                            
                        </div>
                    </div>
                </div>
                @endforeach
                
            </div>
        </div>
    </section>
    <!-- Service Area End -->




    <!-- Upcoming Area Start -->
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
                data-xl-center-mode="true" data-ml-center-mode="true" data-lg-center-mode="true"
                data-md-center-mode="true" data-center-padding="370px" data-xl-center-padding="370px"
                data-ml-center-padding="300px" data-lg-center-padding="200px" data-md-center-padding="80px">

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
                                    <a href="#">{{ $event->title }}</a>
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
                                    <a href="{{ route('user.event.details',['id'=>$event->id]) }}">{{ $event->title }}</a>
                                </h3>

                                <p class="event-text">{{ \Illuminate\Support\Str::limit($event->description, 100) }}</p>

                                <div class="event-footer">
                                    <a href="{{ route('user.event.details',['id'=>$event->id]) }}" class="event-link">Tickets &
                                        Details</a>
                                    <span class="event-price">Price: <span>${{ $event->price }}</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <section class="feature-layout2 space">
        <div class="container">
            <div class="row vs-carousel" data-slide-show="4" data-lg-slide-show="3" data-md-slide-show="2">
                <div class="col-lg-3 col-md-6">
                    <div class="feature-style2">
                        <div class="feature-icon">
                            <img src="assets/img/icons/f-1-1.svg" alt="feature icon 1">
                        </div>
                        <h3 class="feature-title h5">Friendly Team</h3>
                        <p class="feature-text">Bibendum enim facilisis gravida neque convallis a cras. At augue an eget
                            arcu dictum
                            varius duis at. Aliquet eget sit amet tellus cras.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-style2">
                        <div class="feature-icon">
                            <img src="assets/img/icons/f-1-2.svg" alt="feature icon 1">
                        </div>
                        <h3 class="feature-title h5">Brilliant Idea</h3>
                        <p class="feature-text">Bibendum enim facilisis gravida neque convallis a cras. At augue an eget
                            arcu dictum
                            varius duis at. Aliquet eget sit amet tellus cras.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-style2">
                        <div class="feature-icon">
                            <img src="assets/img/icons/f-1-3.svg" alt="feature icon 1">
                        </div>
                        <h3 class="feature-title h5">Perfect Work</h3>
                        <p class="feature-text">Bibendum enim facilisis gravida neque convallis a cras. At augue an eget
                            arcu dictum
                            varius duis at. Aliquet eget sit amet tellus cras.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-style2">
                        <div class="feature-icon">
                            <img src="assets/img/icons/f-1-4.svg" alt="feature icon 1">
                        </div>
                        <h3 class="feature-title h5">Support 24/7</h3>
                        <p class="feature-text">Bibendum enim facilisis gravida neque convallis a cras. At augue an eget
                            arcu dictum
                            varius duis at. Aliquet eget sit amet tellus cras.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-style2">
                        <div class="feature-icon">
                            <img src="assets/img/icons/f-1-4.svg" alt="feature icon 1">
                        </div>
                        <h3 class="feature-title h5">Support 24/7</h3>
                        <p class="feature-text">Bibendum enim facilisis gravida neque convallis a cras. At augue an eget
                            arcu dictum
                            varius duis at. Aliquet eget sit amet tellus cras.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonial Area -->
    @include('layouts.attendees.testimonial')
    <!-- Testimonial Area End -->
    <!-- Blog Area -->
    @include('layouts.attendees.blog')
@endsection
