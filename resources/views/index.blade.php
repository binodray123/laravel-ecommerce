@extends('layouts.app')
@section('content')
<style>
    .h-slider {
        height: 650px !important;
    }

    /* Tablet screens (up to 992px) */
@media (max-width: 992px) {
  .h-slider {
    height: 400px !important;
  }
}

/* Mobile screens (up to 768px) */
@media (max-width: 768px) {
  .h-slider {
    height: 300px !important;
  }
}

/* Small mobile screens (up to 576px) */
@media (max-width: 576px) {
  .h-slider {
    height: 190px !important;
  }
}


</style>
<main >
    <section class="swiper-container js-swiper-slider swiper-number-pagination slideshow h-slider" data-settings='{
          "autoplay": {
         "delay": 5000
         },
         "slidesPerView": 1,
         "effect": "fade",
         "loop": true
            }'>
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="overflow-hidden position-relative h-100">
                    <div class="slideshow-character position-absolute bottom-0 ">
                        <img loading="lazy" src="{{ asset('assets/images/pabiess coll 1.png')}}" width="542" height="733"
                            alt="Woman Fashion 1"
                            class="slideshow-character__img animate animate_fade animate_btt animate_delay-9 w-auto h-auto" />
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="overflow-hidden position-relative h-100">
                    <div class="slideshow-character position-absolute bottom-0 ">
                        <img loading="lazy" src="{{ asset('assets/images/pabiess coll 2.png')}}" width="542" height="733"
                            alt="Woman Fashion 1"
                            class="slideshow-character__img animate animate_fade animate_btt animate_delay-9 w-auto h-auto" />
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="overflow-hidden position-relative h-100">
                    <div class="slideshow-character position-absolute bottom-0 ">
                        <img loading="lazy" src="{{ asset('assets/images/pabiess coll.png')}}" width="542" height="733"
                            alt="Woman Fashion 1"
                            class="slideshow-character__img animate animate_fade animate_btt animate_delay-9 w-auto h-auto" />
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div
                class="slideshow-pagination slideshow-number-pagination d-flex align-items-center position-absolute bottom-0 mb-5">
            </div>
        </div>
    </section>

    <div class="container mw-1620 bg-white border-radius-10">
        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
        <section class="category-carousel container">
            <h2 class="section-title text-center mb-3 pb-xl-2 mb-xl-4">You Might Like</h2>

            <div class="position-relative">
                <div class="swiper-container js-swiper-slider" data-settings='{
          "autoplay": {
            "delay": 5000
          },
          "slidesPerView": 8,
          "slidesPerGroup": 1,
          "effect": "none",
          "loop": true,
          "navigation": {
            "nextEl": ".products-carousel__next-1",
            "prevEl": ".products-carousel__prev-1"
          },
          "breakpoints": {
            "320": {
              "slidesPerView": 2,
              "slidesPerGroup": 2,
              "spaceBetween": 15
            },
            "768": {
              "slidesPerView": 4,
              "slidesPerGroup": 4,
              "spaceBetween": 30
            },
            "992": {
              "slidesPerView": 6,
              "slidesPerGroup": 1,
              "spaceBetween": 45,
              "pagination": false
            },
            "1200": {
              "slidesPerView": 8,
              "slidesPerGroup": 1,
              "spaceBetween": 60,
              "pagination": false
            }
          }
        }'>
                    <div class="swiper-wrapper">
                        @foreach ($categories as $category )
                        <div class="swiper-slide">
                            <img loading="lazy" class="w-100 h-auto mb-3" src="{{ asset('uploads/categories') }}/{{$category->image}}" width="124"
                                height="124" alt="" />
                            <div class="text-center">
                                <a href="{{ route('shop.index',['categories'=>$category->id]) }}" class="menu-link fw-medium">{{$category->name}}</a>
                            </div>
                        </div>
                        @endforeach
                    </div><!-- /.swiper-wrapper -->
                </div><!-- /.swiper-container js-swiper-slider -->

                <div
                    class="products-carousel__prev products-carousel__prev-1 position-absolute top-50 d-flex align-items-center justify-content-center">
                    <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_prev_md" />
                    </svg>
                </div><!-- /.products-carousel__prev -->
                <div
                    class="products-carousel__next products-carousel__next-1 position-absolute top-50 d-flex align-items-center justify-content-center">
                    <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_next_md" />
                    </svg>
                </div><!-- /.products-carousel__next -->
            </div><!-- /.position-relative -->
        </section>

        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

        <section class="hot-deals container">
            <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Hot Deals</h2>
            <div class="row">
                <div
                    class="col-md-6 col-lg-4 col-xl-20per d-flex align-items-center flex-column justify-content-center py-4 align-items-md-start">
                    <h2>Summer Sale</h2>
                    <h2 class="fw-bold">Up to 60% Off</h2>

                    <div class="position-relative d-flex align-items-center text-center pt-xxl-4 js-countdown mb-3"
                        data-date="18-3-2024" data-time="06:50">
                        <div class="day countdown-unit">
                            <span class="countdown-num d-block"></span>
                            <span class="countdown-word text-uppercase text-secondary">Days</span>
                        </div>

                        <div class="hour countdown-unit">
                            <span class="countdown-num d-block"></span>
                            <span class="countdown-word text-uppercase text-secondary">Hours</span>
                        </div>

                        <div class="min countdown-unit">
                            <span class="countdown-num d-block"></span>
                            <span class="countdown-word text-uppercase text-secondary">Mins</span>
                        </div>

                        <div class="sec countdown-unit">
                            <span class="countdown-num d-block"></span>
                            <span class="countdown-word text-uppercase text-secondary">Sec</span>
                        </div>
                    </div>

                    <a href="#" class="btn-link default-underline text-uppercase fw-medium mt-3">View All</a>
                </div>
                <div class="col-md-6 col-lg-8 col-xl-80per">
                    <div class="position-relative">
                        <div class="swiper-container js-swiper-slider" data-settings='{
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": 4,
              "slidesPerGroup": 4,
              "effect": "none",
              "loop": false,
              "breakpoints": {
                "320": {
                  "slidesPerView": 2,
                  "slidesPerGroup": 2,
                  "spaceBetween": 14
                },
                "768": {
                  "slidesPerView": 2,
                  "slidesPerGroup": 3,
                  "spaceBetween": 24
                },
                "992": {
                  "slidesPerView": 3,
                  "slidesPerGroup": 1,
                  "spaceBetween": 30,
                  "pagination": false
                },
                "1200": {
                  "slidesPerView": 4,
                  "slidesPerGroup": 1,
                  "spaceBetween": 30,
                  "pagination": false
                }
              }
            }'>
                            <div class="swiper-wrapper">
                                @foreach ($sproducts as $sproduct )
                                <div class="swiper-slide product-card product-card_style3">
                                    <div class="pc__img-wrapper">
                                        <a href="{{ route('shop.product.detail', ['product_slug' => $sproduct->slug]) }}">
                                            <img loading="lazy" src="{{asset('uploads/products')}}/{{$sproduct->image}}" width="258" height="313"
                                                alt="{{ $sproduct->name }}" class="pc__img">
                                        </a>
                                    </div>

                                    <div class="pc__info position-relative">
                                        <h6 class="pc__title"><a href="{{ route('shop.product.detail' ,['product_slug'=>$sproduct->slug ])}}">{{ $sproduct->name }}</a></h6>
                                        <div class="product-card__price d-flex">
                                            <span class="money price text-secondary">
                                                @if ($sproduct->sale_price)
                                                <s>Rs.{{$sproduct->regular_price}}</s> Rs.{{ $sproduct->sale_price }}
                                                @else
                                                Rs.{{ $sproduct->regular_price }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div><!-- /.swiper-wrapper -->
                        </div><!-- /.swiper-container js-swiper-slider -->
                    </div><!-- /.position-relative -->
                </div>
            </div>
        </section>

        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

        <section class="category-banner container">
            <div class="row">
                <div class="col-md-6">
                    <div class="category-banner__item border-radius-10 mb-5">
                        <img loading="lazy" class="h-auto" src="{{ asset('assets/images/home/demo3/category_9.jpg') }}" width="690" height="665"
                            alt="" />
                        <div class="category-banner__item-mark">
                            Starting at Rs.590
                        </div>
                        <div class="category-banner__item-content">
                            <h3 class="mb-0">Blazers</h3>
                            <a href="#" class="btn-link default-underline text-uppercase fw-medium">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="category-banner__item border-radius-10 mb-5">
                        <img loading="lazy" class="h-auto" src="{{ asset('assets/images/home/demo3/category_10.jpg') }}" width="690" height="665"
                            alt="" />
                        <div class="category-banner__item-mark">
                            Starting at Rs.590
                        </div>
                        <div class="category-banner__item-content">
                            <h3 class="mb-0">Sportswear</h3>
                            <a href="#" class="btn-link default-underline text-uppercase fw-medium">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

        <section class="products-grid container">
            <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Featured Products</h2>

            <div class="row">
                @foreach ($fproducts as $fproduct )
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
                        <div class="pc__img-wrapper">
                            <a href="{{route('shop.product.detail',['product_slug'=>$fproduct->slug])}}">
                                <img loading="lazy" src="{{ asset('uploads/products') }}/{{$fproduct->image}}" width="330" height="400"
                                    alt="{{ $fproduct->name }}" class="pc__img">
                            </a>
                        </div>

                        <div class="pc__info position-relative">
                            <h6 class="pc__title"><a href="{{route('shop.product.detail',['product_slug'=>$fproduct->slug])}}">{{ $fproduct->name }}</a></h6>
                            <div class="product-card__price d-flex align-items-center">
                                <span class="money price text-secondary">
                                    @if ($fproduct->sale_price)
                                    <s>Rs.{{$fproduct->regular_price}}</s> Rs.{{ $fproduct->sale_price }}
                                    @else
                                    Rs.{{ $fproduct->regular_price }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div><!-- /.row -->

            <div class="text-center mt-2">
                <a class="btn-link btn-link_lg default-underline text-uppercase fw-medium" href="#">Load More</a>
            </div>
        </section>
    </div>

    <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

</main>
@endsection
