<section class="events smoke-bg space-top space-bottom">
    <div class="container">

        <div class="row align-items-end justify-content-between">
            <div class="col-lg-5">
                <div class="title-area">
                    <span class="sec-subtitle">Eventino Gallery</span>
                    <h2 class="sec-title">Our Amazing And unforgettable Times</h2>
                </div>
            </div>
            <div class="col-auto">
                <div class="sec-btns">
                    <button class="vs-btn" data-slick-prev="#gallery-slider3">
                        <i class="far fa-arrow-left m-0"></i>
                    </button>
                    <button class="vs-btn" data-slick-next="#gallery-slider3">
                        <i class="far fa-arrow-right m-0"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="row vs-carousel events-slide2 wow fadeInUp gallery-slider3" data-slide-show="1"
            data-center-mode="true" data-xl-center-mode="true" data-ml-center-mode="true" data-lg-center-mode="true"
            data-md-center-mode="true" data-center-padding="370px" data-xl-center-padding="370px"
            data-ml-center-padding="300px" data-lg-center-padding="200px" data-md-center-padding="80px"
            id="gallery-slider3">

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
                                <a href="{{ route('user.event.details', $event->id) }}" class="event-link">Tickets & Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>


</section>
