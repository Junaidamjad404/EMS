@extends('layouts.main')

@section('content')
    <!-- Event Details -->
    <div class="space-top space-extra-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <img src="{{ asset(!empty($event->images->first()->image_url) ? $event->images->first()->image_url : '') }}"
                        alt="Event Details" class="event-details-img mb-50">
                    <div class="row gx-10">
                        <div class="col-md-4 mb-30">
                            <div class="item-card">
                                <div class="item-icon">
                                    <i class="fas fa-calendar"></i>
                                </div>
                                <div class="item-content">
                                    <span class="item-title">Event Date</span>
                                    <span
                                        class="item-text">{{ \Carbon\Carbon::parse($event->date)->format('d F, Y') }}</span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur non nulla sit amet nisl tempus
                        convallis
                        quis ac lectus. Nulla quis lorem ut libero malesuada feugiat. Proin eget tortor risus. Donec rutrum
                        congue leo
                        eget malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim. Vestibulum ac diam sit
                        amet quam
                        vehicula elementum sed sit amet dui.</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur non nulla sit amet nisl tempus
                        convallis
                        quis ac lectus. Nulla quis lorem ut libero malesuada feugiat. Proin eget tortor risus. Donec rutrum
                        congue leo
                        eget malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim. Vestibulum ac diam sit
                        amet quam
                        vehicula elementum sed sit amet dui.</p>
                    <div class="row">
                        @foreach ($event->images as $image)
                            <div class="col-md-6">
                                <img src="{{ asset($image->image_url) }}" alt="Event Details"
                                    class="event-details-img2 mb-30">
                            </div>
                        @endforeach

                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur non nulla sit amet nisl tempus
                        convallis
                        quis ac lectus. Nulla quis lorem ut libero malesuada feugiat. Proin eget tortor risus. Donec rutrum
                        congue leo
                        eget malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim. Vestibulum ac diam sit
                        amet quam
                        vehicula elementum sed sit amet dui.</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur non nulla sit amet nisl tempus
                        convallis
                        quis ac lectus. Nulla quis lorem ut libero malesuada feugiat. Proin eget tortor risus. Donec rutrum
                        congue leo
                        eget malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim. Vestibulum ac diam sit
                        amet quam
                        vehicula elementum sed sit amet dui.</p>
                    <div class="row align-items-center justify-content-between">
                        <div class="col-lg-auto">
                            <p class="wp-block-tag-cloud">
                                <span class="wp-block-tag-cloud__title">Tags:</span>
                                <a href="#" class="tag-cloud-link tag-link-12">Business,</a>
                                <a href="#" class="tag-cloud-link tag-link-4">Education,</a>
                                <a href="#" class="tag-cloud-link tag-link-13">Art</a>
                            </p>
                        </div>
                        <div class="col-auto text-end">
                            <span class="share-links-title">Social Icon:</span>
                            <ul class="social-links">
                                <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                                        target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                                <li>
                                                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($event->title) }}&url={{ urlencode(request()->url()) }}"
                                                        target="_blank">
                                                        <i class="fab fa-twitter"></i>                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="https://www.instagram.com/?url={{ urlencode(request()->url()) }}"
                                                        target="_blank">
                                                        <i class="fab fa-instagram"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="https://dribbble.com/shot/new?url={{ urlencode(request()->url()) }}"
                                                        target="_blank">
                                                        <i class="fab fa-dribbble"></i>
                                                    </a>
                                                </li>
                            </ul><!-- End Social Share -->
                        </div>
                    </div>
                    <div class="post-pagination">
                        <div class="row justify-content-between align-items-center">
                            <div class="col">
                                <div class="post-pagi-box prev">
                                    <a href="blog-details.html"><img src="{{ asset('assets/img/events/e-d-1-4.jpg') }}"
                                            alt="pagi"></a>
                                    <a href="blog-details.html">Previous Post</a>
                                </div>
                            </div>
                            <div class="col-auto d-none d-sm-block">
                                <a href="blog.html" class="pagi-icon"><i class="fas fa-th"></i></a>
                            </div>
                            <div class="col">
                                <div class="post-pagi-box next">
                                    <a href="blog-details.html"><img src="{{ asset('assets/img/events/e-d-1-5.jpg') }}"
                                            alt="pagi"></a>
                                    <a href="blog-details.html">Next Post</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="event-timeline">
                        <div class="row justify-content-between d-none d-xl-flex">
                            <div class="col-auto">
                                <div class="timeline-step"></div>
                            </div>
                            <div class="col-auto">
                                <div class="timeline-step"></div>
                            </div>
                            <div class="col-auto">
                                <div class="timeline-step"></div>
                            </div>
                        </div>
                        <div class="event-timeline__bar">
                            <div class="timeline-line"></div>
                        </div>
                        <div class="row justify-content-center justify-content-xl-between">
                            <div class="col-auto">
                                <div class="timeline-item">
                                    <i class="fas fa-microphone"></i>
                                    <span>Speakers</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="timeline-item">
                                    <i class="fas fa-calendar"></i>
                                    <span>Schedule</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="timeline-item">
                                    <i class="fas fa-images"></i>
                                    <span>Gallery</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-7">
                            <h3 class="sec-title">View Our Gallery</h3>
                            <p>Cras semper, massa vel aliquam luctus, eros odio tempor turpis, ac placerat metus tortor eget
                                magna.</p>
                        </div>
                        @foreach ($event->images as $image)
                            <div class="col-md-6">

                                <div class="gallery-style1">
                                    <a href="{{ asset($image->image_url) }}" class="popup-image popup-link">
                                        <i class="fas fa-image"></i>
                                    </a>
                                    <div class="overlay"></div>
                                    <div class="gallery-thumb">
                                        <img src="{{ asset($image->image_url) }}" alt="gallery">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @foreach ($event->videos as $video)
                            <div class="col-md-6">
                                <div class="gallery-style1">
                                    <a href="{{ asset($video->video_url) }}" class="popup-video popup-link">
                                        <i class="fas fa-play"></i>
                                    </a>
                                    <div class="overlay"></div>
                                    <div class="gallery-thumb">
                                        <img src="{{ asset($video->video_url) }}" alt="gallery">
                                    </div>
                                </div>

                            </div>
                        @endforeach


                    </div>
                    <div class="vs-comments-wrap">
                        <h2 class="blog-inner-title">3 Comments</h2>
                        <ul class="comment-list">
                            <li class="vs-comment-item">
                                <div class="vs-post-comment">
                                    <div class="comment-avater">
                                        <img src="assets/img/users/user-1-1.jpg" alt="Comment Author">
                                    </div>
                                    <div class="comment-content">
                                        <span class="commented-on">28 Jan, 2023</span>
                                        <h4 class="name h4">David Warnner</h4>
                                        <p class="text">Collaboratively empower multifunctional e-commerce for
                                            prospective applications.
                                            Seamlessly productivity plug-and-play markets whereas synergistic scenarios.</p>
                                        <div class="reply_and_edit">
                                            <a href="blog-details.html" class="replay-btn"><i
                                                    class="fas fa-reply"></i>Replay</a>
                                        </div>
                                    </div>
                                </div>
                                <ul class="children">
                                    <li class="vs-comment-item">
                                        <div class="vs-post-comment">
                                            <div class="comment-avater">
                                                <img src="assets/img/users/user-1-2.jpg" alt="Comment Author">
                                            </div>
                                            <div class="comment-content">
                                                <span class="commented-on">28 Jan, 2023</span>
                                                <h4 class="name h4">Maliha Raw</h4>
                                                <p class="text">Collaboratively empower multifunctional e-commerce for
                                                    prospective applications.
                                                    Seamlessly productivity plug-and-play markets whereas synergistic
                                                    scenarios.</p>
                                                <div class="reply_and_edit">
                                                    <a href="blog-details.html" class="replay-btn"><i
                                                            class="fas fa-reply"></i>Replay</a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="vs-comment-item">
                                <div class="vs-post-comment">
                                    <div class="comment-avater">
                                        <img src="assets/img/users/user-1-3.jpg" alt="Comment Author">
                                    </div>
                                    <div class="comment-content">
                                        <span class="commented-on">28 Jan, 2023</span>
                                        <h4 class="name h4">David Warnner</h4>
                                        <p class="text">Collaboratively empower multifunctional e-commerce for
                                            prospective applications.
                                            Seamlessly productivity plug-and-play markets whereas synergistic scenarios.</p>
                                        <div class="reply_and_edit">
                                            <a href="blog-details.html" class="replay-btn"><i
                                                    class="fas fa-reply"></i>Replay</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="vs-comment-form  ">
                        <div id="respond" class="comment-respond">
                            <div class="form-title">
                                <h3 class="sec-title">Leave a Reply</h3>
                            </div>
                            <div class="form-inner">
                                <div class="row gx-20">
                                    <div class="col-md-6 form-group">
                                        <input type="text" class="form-control" placeholder="Your Name">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <input type="email" class="form-control" placeholder="Email Address">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="col-12 form-group">
                                        <textarea class="form-control" placeholder="Type Your Message"></textarea>
                                    </div>
                                    <div class="col-12 ">
                                        <div class="custom-checkbox notice">
                                            <input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent"
                                                type="checkbox" value="yes">
                                            <label for="wp-comment-cookies-consent"> Save my name, email, and
                                                website in this browser for the next time I comment.</label>
                                        </div>
                                    </div>
                                    <div class="col-12 form-group mb-0">
                                        <button class="vs-btn">Post Comment<i class="far fa-arrow-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="sidebar-area">
                        <div class="widget">
                            <h3 class="widget_title">
                                Event Details
                                <img src="{{ asset('assets/img/shapes/d-1-2.svg') }}">
                            </h3>
                            <ul class="wp-block-categories-list wp-block-details">
                                <li>
                                    <div class="item-card">
                                        <div class="item-icon">
                                            <i class="fas fa-calendar-check"></i>
                                        </div>
                                        <div class="item-content">
                                            <span class="item-title">Start Date</span>
                                            <span
                                                class="item-text">{{ \Carbon\Carbon::parse($event->date)->format('F j, Y - h:ia') }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="item-card">
                                        <div class="item-icon">
                                            <i class="fas fa-calendar-times"></i>
                                        </div>
                                        <div class="item-content">
                                            <span class="item-title">Close Date</span>
                                            <span
                                                class="item-text">{{ \Carbon\Carbon::parse($event->date)->addHours(3)->format('F j, Y - h:ia') }}
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="item-card">
                                        <div class="item-icon">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div class="item-content">
                                            <span class="item-title">Statues</span>
                                            <span class="item-text">
                                                {{ ucfirst($event->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="item-card">
                                        <div class="item-icon">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <div class="item-content">
                                            <span class="item-title">Location</span>
                                            <span class="item-text">{{ $event->location }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="item-card">
                                        <div class="item-icon">
                                            <i class="fas fa-map-marked-alt"></i>
                                        </div>
                                        <div class="item-content">
                                            <span class="item-title">Venue</span>
                                            <span class="item-text">{{ $event->location }}</span>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="item-card">
                                        <div class="item-icon">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="item-content">
                                            <span class="item-title">Organizer</span>
                                            <span class="item-text">{{ $event->organizer->name }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="item-card">
                                        <div class="item-icon">
                                            <i class="fas fa-folder-open"></i>
                                        </div>
                                        <div class="item-content">
                                            <span class="item-title">Category</span>
                                            <span class="item-text">{{ $event->category->name }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="item-card">
                                        <div class="item-icon">
                                            <i class="fas fa-ticket-alt"></i>
                                        </div>
                                        <div class="item-content">
                                            <span class="item-title">Tickets</span>
                                            <ul>
                                                @foreach ($event->ticketTypes as $ticket)
                                                    <li>
                                                        <span class="item-text">{{ $ticket->name }} -
                                                            {{ $ticket->pivot->quantity }} Remaining</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="item-card">
                                        <div class="item-icon">
                                            <i class="fas fa-share-alt-square"></i>
                                        </div>
                                        <div class="item-content">
                                            <span class="item-title">Networks</span>
                                            <ul class="social-links">
                                                <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                                        target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                                <li>
                                                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($event->title) }}&url={{ urlencode(request()->url()) }}"
                                                        target="_blank">
                                                        <i class="fab fa-twitter"></i>                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="https://www.instagram.com/?url={{ urlencode(request()->url()) }}"
                                                        target="_blank">
                                                        <i class="fab fa-instagram"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="https://dribbble.com/shot/new?url={{ urlencode(request()->url()) }}"
                                                        target="_blank">
                                                        <i class="fab fa-dribbble"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>

                            <a href="{{ route('event.tickets', $event->id) }}"
                                class="vs-btn w-100 {{ ucfirst($event->status) === 'Pending' || \Carbon\Carbon::parse($event->date)->isPast() ? 'd-none' : '' }}"
                                tabindex="0">
                                Buy Ticket
                            </a>

                        </div>
                        <div class="widget">
                            <h3 class="widget_title">
                                Organizer Details
                                <img src="{{ asset('assets/img/shapes/d-1-2.svg') }}">
                            </h3>
                            <div class="sidebar-info">
                                <div class="info-logo">
                                    <img src="{{ asset('assets/img/brand/sidebar-brand-1-1.png') }}" alt="logo">
                                </div>
                                <div class="info-list">
                                    <h3 class="sec-title">{{ $event->organizer->name }}</h3>
                                    <ul>
                                        <li>
                                            <i class="fas fa-phone-alt"></i>
                                            <a href="tel:+052 (699) 256 - 009">052 (699) 256 - 009</a>
                                        </li>
                                        <li>
                                            <i class="fas fa-envelope"></i>
                                            <a
                                                href="mailto:{{ $event->organizer->email }}">{{ $event->organizer->email }}</a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                                            <a href="#"><i class="fab fa-twitter"></i></a>
                                            <a href="#"><i class="fab fa-instagram"></i></a>
                                            <a href="#"><i class="fab fa-behance"></i></a>
                                            <a href="#"><i class="fab fa-youtube"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="widget">
                            <h3 class="widget_title">
                                Sponsors
                                <img src="{{ asset('assets/img/shapes/d-1-2.svg') }}">
                            </h3>
                            <div class="sidebar-brand">
                                <div class="brand-logo">
                                    <img src="{{ asset('assets/img/brand/sidebar-brand-1-2.png') }}" alt="brand">
                                </div>
                                <div class="brand-logo">
                                    <img src="{{ asset('assets/img/brand/sidebar-brand-1-3.png') }}" alt="brand">
                                </div>
                                <div class="brand-logo">
                                    <img src="{{ asset('assets/img/brand/sidebar-brand-1-4.png') }}" alt="brand">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
