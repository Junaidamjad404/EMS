<section class="service smoke-bg space">
    <div class="container">
        <div class="row justify-content-between align-items-end">
            <div class="col-lg-6">
                <div class="title-area">
                    <span class="sec-subtitle">Services</span>
                    <h2 class="sec-title">Get A New Experience With Eventino Services</h2>
                </div>
            </div>
            <div class="col-auto d-none d-lg-block">
                <div class="sec-btns style1">
                    <button class="vs-btn" data-slick-prev="#service-slider1">
                        <i class="far fa-arrow-left"></i>
                    </button>
                    <button class="vs-btn" data-slick-next="#service-slider1">
                        <i class="far fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="row vs-carousel" data-slide-show="4" data-lg-slide-show="3" data-md-slide-show="2"
            id="service-slider1">

            @foreach ($categories as $key=>$category)
                <div class="col-lg-3">
                    <div class="service-style1">
                        <div class="overlay"></div>
                        <a href="service-details.html" class="service-plus">
                            <i class="far fa-plus"></i>
                        </a>
                        <div class="service-img">
                            <img src="{{ asset('assets/img/services/s-1-' . ($key + 1) . '.jpg') }}" alt="service image">
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
