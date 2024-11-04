<!doctype html>
<html class="no-js" lang="zxx">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>FêteFlow</title>
  <meta name="author" content="vecuro">
  <meta name="description" content="Eventino - IT Solution & Service HTML Template">
  <meta name="keywords" content="Eventino - IT Solution & Service HTML Template" />
  <meta name="robots" content="INDEX,FOLLOW">
  <!-- Mobile Specific Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Favicons - Place favicon.ico in the root directory -->
  <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets/img/favicons/apple-icon-57x57.png') }}">
  <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/img/favicons/apple-icon-60x60.png') }}">
  <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/img/favicons/apple-icon-72x72.png') }}">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/favicons/apple-icon-76x76.png') }}">
  <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/img/favicons/apple-icon-114x114.png') }}">
  <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/img/favicons/apple-icon-120x120.png') }}">
  <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/img/favicons/apple-icon-144x144.png') }}">
  <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/img/favicons/apple-icon-152x152.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/favicons/apple-icon-180x180.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicons/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/img/favicons/favicon-96x96.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicons/favicon-16x16.png') }}">
  <link rel="manifest" href="{{ asset('assets/img/favicons/manifest.json') }}">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="{{ asset('assets/img/favicons/ms-icon-144x144.png') }}">
  <meta name="theme-color" content="#ffffff">
  
  <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Toastr CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <!--==============================
	  Google Fonts
	============================== -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inria+Sans:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
  <!--==============================
	    All CSS File
	============================== -->
  <!-- Bootstrap -->
  
 <!-- <link rel="stylesheet" href="assets/css/app.min.css"> -->
  <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
  <!-- Fontawesome Icon -->
  <link rel="stylesheet" href="{{asset('assets/css/fontawesome.min.css')}}">
  <!-- Magnific Popup -->
  <link rel="stylesheet" href="{{asset('assets/css/magnific-popup.min.css')}}">
  <!-- Slick Slider -->
  <link rel="stylesheet" href="{{asset('assets/css/slick.min.css')}}">
  <!-- Custom Phone Number Input -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.7.3/build/css/intlTelInput.css">
  <!-- Theme Custom CSS -->
  <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
  <!-- Toastr JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <!-- Stripe JS -->
  <script src="https://js.stripe.com/v3/"></script>
    <style>
        .toast-info {
          background-color: #8c00ff !important; /* Info notifications */
      }
    </style>
</head>

<body>
  <!--[if lte IE 9]>
    	<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->
  <!--********************************
   		Code Start From Here 
	******************************** -->
  <!--==============================
	Preloader
	==============================-->
  {{-- <div class="preloader">
    <button class="vs-btn preloaderCls">Cancel Preloader </button>
    <div class="preloader-inner">
      <img src="{{ asset('assets/img/logo.svg') }}" alt="logo">
      <span class="loader"></span>
    </div>
  </div> --}}
  <!--==============================
    Mobile Menu
  ============================== -->
  <div class="vs-menu-wrapper">
    <div class="vs-menu-area text-center">
      <div class="mobile-logo">
        <a href="index.html"><img src="{{ asset('assets/img/logo-white2.svg') }}" alt="Carmax" class="logo"></a>
        <button class="vs-menu-toggle"><i class="fal fa-times"></i></button>
      </div>
      <div class="vs-mobile-menu">
        <ul>
          <li class="menu-item-has-children">
            <a href="index.html">Home</a>
            <ul class="sub-menu">
              <li><a href="index.html">Home 1</a></li>
              <li><a href="index-2.html">Home 2</a></li>
              <li><a href="index-3.html">Home 3</a></li>
            </ul>
          </li>
          <li>
            <a href="about.html">About Us</a>
          </li>
          <li class="menu-item-has-children">
            <a href="shop.html">Shop</a>
            <ul class="sub-menu">
              <li><a href="shop.html">Shop Grid</a></li>
              <li><a href="shop-sidebar.html">Shop Sidebar</a></li>
              <li><a href="shop-details.html">Shop Details</a></li>
              <li><a href="cart.html">Cart</a></li>
              <li><a href="checkout.html">Checkout</a></li>
              <li><a href="account.html">My Account</a></li>
            </ul>
          </li>
          <li class="menu-item-has-children">
            <a href="#none">Pages</a>
            <ul class="sub-menu">
              <li><a href="index.html">Home 1</a></li>
              <li><a href="index-2.html">Home 2</a></li>
              <li><a href="index-3.html">Home 3</a></li>
              <li><a href="about.html">About Us</a></li>
              <li><a href="price.html">Pricing Plans</a></li>
              <li><a href="appointment.html">Appointment</a></li>
              <li><a href="blog.html">Blog Grid</a></li>
              <li><a href="blog-sidebar.html">Blog Sidebar</a></li>
              <li><a href="blog-sidebar-2.html">Blog Sidebar 2</a></li>
              <li><a href="blog-details.html">Blog Details</a></li>
              <li><a href="services.html">Service</a></li>
              <li><a href="service-details.html">Service Details</a></li>
              <li><a href="faq.html">FAQs</a></li>
              <li><a href="faq-2.html">FAQs 2</a></li>
              <li><a href="shop.html">Shop Grid</a></li>
              <li><a href="shop-sidebar.html">Shop Sidebar</a></li>
              <li><a href="shop-details.html">Shop Details</a></li>
              <li><a href="cart.html">Cart</a></li>
              <li><a href="checkout.html">Checkout</a></li>
              <li><a href="team.html">Team</a></li>
              <li><a href="team-details.html">Team Details</a></li>
              <li><a href="testimonials.html">Testimonials</a></li>
              <li><a href="project.html">Projects</a></li>
              <li><a href="project-details.html">Projects Details</a></li>
              <li><a href="contact.html">Contact Us</a></li>
              <li><a href="account.html">My Account</a></li>
              <li><a href="404.html">Error Page</a></li>
            </ul>
          </li>
          <li class="menu-item-has-children">
            <a href="shop.html">Elements</a>
            <ul class="sub-menu">
              <li><a href="element-typography.html">Typography</a></li>
              <li><a href="element-buttons.html">Buttons</a></li>
              <li><a href="element-columns.html">Columns</a></li>
              <li><a href="element-messagebox.html">Message Box</a></li>
              <li><a href="element-separators.html">Separators</a></li>
              <li><a href="element-services.html">Services Card</a></li>
              <li><a href="element-testimonials.html">Testimonials</a></li>
              <li><a href="element-projectbox.html">Project Box</a></li>
              <li><a href="element-priceplan.html">Price Plan</a></li>
              <li><a href="element-counters.html">Counters</a></li>
              <li><a href="element-accordions.html">Accordions</a></li>
              <li><a href="element-team.html">Team</a></li>
              <li><a href="element-process.html">Process</a></li>
              <li><a href="element-blogcard.html">Blog Card</a></li>
              <li><a href="element-ctas.html">Call To Actions</a></li>
              <li><a href="element-map.html">Google Map</a></li>
            </ul>
          </li>
          <li>
            <a href="contact.html">Contact Us</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!--==============================
      Offcanvas
  ============================== -->
  <div class="sidemenu-wrapper d-none d-lg-block">
    <div class="sidemenu-content">
      <button class="closeButton sideMenuCls">
        <i class="far fa-times"></i>
      </button>
      <div class="widget">
        <div class="vs-widget-about">
          <div class="footer-logo">
            <a href="index.html"><img src="{{ asset('assets/img/logo.svg') }}" alt="Eventino"></a>
          </div>
          <p>
            Ut tellus dolor, dapibus eget, elementum ifend cursus eleifend,
            elit. Aenea ifen dn tor wisi Aliquam er at volutpat. Dui ac tui
            end cursus eleifendrpis.
          </p>
          <div class="footer-social">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-behance"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
          </div>
        </div>
      </div>
      <div class="widget">
        <h3 class="widget_title h4">Recent Articles</h3>
        <div class="recent-post-wrap">
          <div class="recent-post">
            <div class="media-img">
              <a href="blog-details.html"><img src="{{ asset('assets/img/blog/recent-post-1-1.jpg') }}" alt="Blog Image"></a>
            </div>
            <div class="media-body">
              <h4 class="post-title">
                <a class="text-inherit" href="blog-details.html">
                  Global Business Goal Make Life Easy From Tech
                </a>
              </h4>
              <div class="recent-post-meta">
                <a href="blog.html"><i class="fas fa-calendar-alt"></i>09 Aug, 2022</a>
              </div>
            </div>
          </div>
          <div class="recent-post">
            <div class="media-img">
              <a href="blog-details.html"><img src="{{ asset('assets/img/blog/recent-post-1-2.jpg') }}" alt="Blog Image"></a>
            </div>
            <div class="media-body">
              <h4 class="post-title">
                <a class="text-inherit" href="blog-details.html">
                  Celebrating in Style High-Tech Solutions for Modern
                </a>
              </h4>
              <div class="recent-post-meta">
                <a href="blog.html"><i class="fas fa-calendar-alt"></i>05 Mar, 2022</a>
              </div>
            </div>
          </div>
          <div class="recent-post">
            <div class="media-img">
              <a href="blog-details.html"><img src="{{ asset('assets/img/blog/recent-post-1-2.jpg') }}" alt="Blog Image"></a>
            </div>
            <div class="media-body">
              <h4 class="post-title">
                <a class="text-inherit" href="blog-details.html">
                  Events The Intersection of Technology and Fun
                </a>
              </h4>
              <div class="recent-post-meta">
                <a href="blog.html"><i class="fas fa-calendar-alt"></i>20 Jan, 2022</a>
              </div>
            </div>
          </div>
          <div class="recent-post">
            <div class="media-img">
              <a href="blog-details.html"><img src="{{ asset('assets/img/blog/recent-post-1-2.jpg') }}" alt="Blog Image"></a>
            </div>
            <div class="media-body">
              <h4 class="post-title">
                <a class="text-inherit" href="blog-details.html">
                  Smart Parties How Tech is Revolutionizing Celebrations
                </a>
              </h4>
              <div class="recent-post-meta">
                <a href="blog.html"><i class="fas fa-calendar-alt"></i>20 Jan, 2022</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--==============================
        Header Area
    ==============================-->
  @include('layouts.attendees.header')
  
  @yield('content')
  <!-- Blog Area End -->
  <!-- Footer Area -->
  @include('layouts.attendees.footer')
  <!-- Footer Area End -->
  <!--********************************
			Code End  Here 
	******************************** -->
  <!--==============================
        All Js File
    ============================== -->
  <!-- Jquery -->
  <script src="{{asset('assets/js/vendor/jquery-3.6.0.min.js')}}"></script>
  <!-- Slick Slider -->
  <script src="{{asset('assets/js/slick.min.js')}}"></script>
  <!-- Bootstrap -->
  <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
  <!-- WOW.js Animation -->
  <script src="{{asset('assets/js/wow.min.js')}}"></script>
  <!-- Magnific Popup -->
  <script src="{{asset('assets/js/jquery.magnific-popup.min.js')}}"></script>
  <!-- Isotope Filter -->
  <script src="{{asset('assets/js/imagesloaded.pkgd.min.js')}}"></script>
  <script src="{{asset('assets/js/isotope.pkgd.min.js')}}"></script>
  <!-- Custom Phone Number Input -->
  <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.7.3/build/js/intlTelInput.min.js"></script>
  <!-- Main Js File -->
  <script src="{{asset('assets/js/main.js')}}"></script>
</body>

</html>