@extends('layouts.main')

@section('content')
    <!--==============================
                        Hero Area
                        ==============================-->
    <section>
        <div class="vs-carousel style2" data-slide-show="1" data-fade="true" data-arrows="false">
            <div>
                <div class="hero-inner style3">
                    <div class="hero-bg" data-bg-src="{{ asset('assets/img/bg/h-1-1.jpg') }}"></div>
                    <div class="container">
                        <div class="row justify-content-between">
                            <div class="col-lg-8 mx-auto">
                                <div class="hero-content style3 text-center">
                                    <span class="hero-subtitle">Get Best event Management</span>
                                    <h1 class="hero-title">Events, Meetups & Conferences</h1>
                                    <p class="hero-text">Sed porttitor lectus nibh. Vestibulum ac diam sit amet quam
                                        vehicula lentum sed sit
                                        amet amet quam vehicula dui amet quam vehicula.</p>
                                    <div class="hero-btns justify-content-center">
                                        <a href="about.html" class="vs-btn">
                                            About Us
                                        </a>
                                        <a href="about.html" class="vs-btn style3">
                                            Get Started
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="hero-inner style3">
                    <div class="hero-bg" data-bg-src="{{ asset('assets/img/bg/h-1-3.jpg') }}"></div>
                    <div class="container">
                        <div class="row justify-content-between">
                            <div class="col-lg-9 mx-auto">
                                <div class="hero-content style3 text-center">
                                    <span class="hero-subtitle">Get Best event Management</span>
                                    <h1 class="hero-title">Global Marketing Meetup Strategies for 2025</h1>
                                    <p class="hero-text">Sed porttitor lectus nibh. Vestibulum ac diam sit amet quam
                                        vehicula lentum sed sit
                                        amet amet quam vehicula dui amet quam vehicula.</p>
                                    <div class="hero-btns justify-content-center">
                                        <a href="about.html" class="vs-btn">
                                            About Us
                                        </a>
                                        <a href="about.html" class="vs-btn style3">
                                            Get Started
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
    <!-- Hero End Area -->
     <!-- Gallery Area Start -->
    @include('layouts.attendees.gallery')
    <!-- Gallery Area End -->
    <!-- About Area Start -->
    @include('layouts.attendees.aboutUs')
    <!-- About Area End -->
    <!-- Service Area -->
    @include('layouts.attendees.service')
    <!-- Service Area End -->
    <!-- Counter Area Start -->
    @include('layouts.attendees.counter')
    <!-- Counter Area End -->
    <!-- Video Area -->
    @include('layouts.attendees.video')
    <!-- Video Area End -->
    <!-- Team Area -->
    @include('layouts.attendees.team')
    <!-- Team Area end -->
    <!-- Testimonial Area -->
    @include('layouts.attendees.testimonial')
    <!-- Testimonial Area End -->
   
    <!-- Blog Area -->
    @include('layouts.attendees.blog')
@endsection
