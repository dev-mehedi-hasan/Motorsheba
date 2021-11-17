@extends('frontend.layouts.app')

@section('content')
    {{-- Categories , Sliders . Today's deal --}}
    <div class="home-banner-area mb-4 pt-3">
        <div class="container">
            <div class="row gutters-10 position-relative">
                {{-- <div class="col-lg-3 position-static d-none d-xl-block">
                    @include('frontend.partials.category_menu')
                </div> --}}

                <div class="col-xl-12">
                    @if (get_setting('home_slider_images') != null)
                        <div class="homepage-slider aiz-carousel dots-inside-bottom mobile-img-auto-height" data-dots="true" data-arrows="true" data-infinite="true" data-autoplay="true">
                            @php $slider_images = json_decode(get_setting('home_slider_images'), true);  @endphp
                            @foreach ($slider_images as $key => $value)
                                <div class="carousel-box">
                                    <a href="{{ json_decode(get_setting('home_slider_links'), true)[$key] }}">
                                        <img
                                            class="d-block mw-100 img-fit rounded shadow-sm overflow-hidden"
                                            src="{{ uploaded_asset($slider_images[$key]) }}"
                                            alt="{{ env('APP_NAME')}} promo"
                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';"
                                        >
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- All Brands Carousel--}}
    @php
    $all_brands = \App\Brand::all();
    @endphp
    @if (count($all_brands) > 0)
        <section class="mb-4">
            <div class="container">
                <div class="px-2 py-4 px-md-4 py-md-3 bg-white rounded">
                    <div class="d-flex flex-wrap mb-3 align-items-baseline justify-content-center">
                        <h3 class="h3 fw-700 mb-0">
                            <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Our Exclusive Brands') }}</span>
                        </h3>
                    </div>
                    <ul class="list-unstyled px-3 mb-0 row gutters-5 all-brand-carousel mt-3">
                        @foreach ($all_brands as $key => $brand)
                            <li class="minw-0">
                                <a href="{{ route('products.brand', $brand->slug) }}" class="d-block rounded text-center p-2 text-reset">
                                    <img
                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ uploaded_asset($brand->logo) }}"
                                        alt="{{ $brand->getTranslation('name') }}"
                                        class="lazyload img-fit h-lg-110px h-md-80px h-50px"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';"
                                    >
                                    {{-- <div class="text-truncate fs-12 fw-600 mt-2">{{ $brand->getTranslation('name') }}</div> --}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>
    @endif

    {{-- Car Parts Search--}}
    <section class="mb-4 car-parts-search">
        <div class="container">
            <div class="set-bg px-2 py-4 px-md-4 py-md-3 bg-dark rounded">
                <div class="d-flex flex-wrap mb-3 align-items-baseline justify-content-center">
                    <h3 class="h3 fw-700 mb-0">
                        <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block text-white">{{ translate('আপনার গাড়ির যন্ত্রাংশ খুঁজুন') }}</span>
                    </h3>
                </div>
                <div class="d-flex flex-wrap mb-3 align-items-baseline justify-content-center">
                    <p class="p fw-600 mb-0">
                        <span class="pb-3 d-inline-block text-white">{{ translate('আমাদের আছে সকল গাড়ির আমদানিকৃত যন্ত্রাংশ') }}</span>
                    </p>
                </div>
                <form action="{{route('search.product.compatibility')}}" method="GET" autocomplete="off" class="row justify-content-center form form-horizontal mar-top text-center mt-3">
                    <div class="col-6 col-lg-2 col-md-3 fw-600 d-inline-block form-group mb-3">
                        <select id="manufacturer" name="manufacturer_id" aria-label="manufacturer_id" class="fw-600 form-control aiz-selectpicker" aria-hidden="true" data-live-search="true">
                            <option class="fw-600" value="0">Select Manufacturer</option>
                            @foreach(\App\Manufacturer::orderBy('name', 'DESC')->get() as $manufacturer)
                                <option class="fw-600" value="{{$manufacturer->id}}">{{$manufacturer->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-lg-2 col-md-3 fw-600 d-inline-block form-group mb-3">
                        <select id="car_model" name="car_model_id" aria-label="car_model_id" class="fw-600 form-control aiz-selectpicker" aria-hidden="true" data-live-search="true">
                            <option class="fw-600" value="">Select Model</option>
                        </select>
                    </div>
                    <div class="col-6 col-lg-2 col-md-3 fw-600 d-inline-block form-group mb-3">
                        <select id="manufacturing_year" name="manufacturing_year_id" aria-label="manufacturing_year_id" class="fw-600 form-control aiz-selectpicker" aria-hidden="true" data-live-search="true">
                            <option class="fw-600" value="" >Select Year</option>
                            @foreach ( \App\ManufacturingYear::orderBy('year', 'DESC')->get() as $manufacturing_year)
                                <option class="fw-600" value="{{$manufacturing_year->id}}">{{$manufacturing_year->year}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-lg-2 col-md-3 fw-600 d-inline-block form-group mb-3">
                        <select name="product_category_id" aria-label="product_category_id" class="fw-600 form-control aiz-selectpicker" aria-hidden="true" data-live-search="true">
                            <option class="fw-600" value="">Select Type</option>
                            @foreach(\App\Category::where('parent_id', 0)->orderBy('name', 'DESC')->get() as $category)
                                <option class="fw-600" value="{{$category->id}}">{{$category->name}}</option>
                                @foreach ($category->childrenCategories as $childCategory)
                                    @include('categories.child_category', ['child_category' => $childCategory])
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-lg-2 fw-600 d-inline-block form-group mb-3">
                        <button class="btn btn-primary shadow-md w-100 hov-bg-primary" type="submit">খুঁজুন</button>
                    </div>
                </form>
            </div>
        </div>
    </section>


    {{-- Banner section 1
    @if (get_setting('home_banner1_images') != null)
    <div class="mb-4">
        <div class="container">
            <div class="row gutters-10">
                @php $banner_1_imags = json_decode(get_setting('home_banner1_images')); @endphp
                @foreach ($banner_1_imags as $key => $value)
                    <div class="col-xl col-md-6">
                        <div class="mb-3 mb-lg-0">
                            <a href="{{ json_decode(get_setting('home_banner1_links'), true)[$key] }}" class="mb-3 d-block text-reset">
                                <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset($banner_1_imags[$key]) }}" alt="{{ env('APP_NAME') }} promo" class="rounded img-fit lazyload">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif --}}


    {{-- Today's deal
    @php
        $num_todays_deal = count(filter_products(\App\Product::where('published', 1)->where('todays_deal', 1 ))->get());
    @endphp
    @if($num_todays_deal > 0)
    <section class="mb-4">
        <div class="container">
            <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">

                <div class="d-flex flex-wrap mb-3 align-items-baseline border-bottom">
                    <h3 class="h5 fw-700 mb-0">
                        <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Todays Deal') }}</span>
                    </h3>
                </div>

                <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="5" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true'>
                    @foreach (filter_products(\App\Product::where('published', 1)->where('todays_deal', '1'))->get() as $key => $product)
                        @if ($product != null)
                            <div class="carousel-box">
                                @include('frontend.partials.product_box_1',['product' => $product])
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif --}}


    {{-- Flash Deal
    @php
        $flash_deal = \App\FlashDeal::where('status', 1)->where('featured', 1)->first();
    @endphp
    @if($flash_deal != null && strtotime(date('Y-m-d H:i:s')) >= $flash_deal->start_date && strtotime(date('Y-m-d H:i:s')) <= $flash_deal->end_date)
    <section class="mb-4">
        <div class="container">
            <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">

                <div class="d-flex flex-wrap mb-3 align-items-baseline border-bottom">
                    <h3 class="h5 fw-700 mb-0">
                        <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Flash Sale') }}</span>
                    </h3>
                    <div class="aiz-count-down ml-auto ml-lg-3 align-items-center" data-date="{{ date('Y/m/d H:i:s', $flash_deal->end_date) }}"></div>
                    <a href="{{ route('flash-deal-details', $flash_deal->slug) }}" class="ml-auto mr-0 btn btn-primary btn-sm shadow-md w-100 w-md-auto">{{ translate('View More') }}</a>
                </div>

                <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="5" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true'>
                    @foreach ($flash_deal->flash_deal_products as $key => $flash_deal_product)
                        @php
                            $product = \App\Product::find($flash_deal_product->product_id);
                        @endphp
                        @if ($product != null && $product->published != 0)
                            <div class="carousel-box">
                                @include('frontend.partials.product_box_1',['product' => $product])
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif --}}

    {{-- Featured Section --}}
    <div id="section_featured">

    </div>

    {{-- Best Selling  --}}
    <div id="section_best_selling">

    </div>

    {{-- Categories --}}
    @php
    $featured_categories = \App\Category::where('featured', 1)->get();
    @endphp
    @if (count($featured_categories) > 0)
        <section class="mb-4">
            <div class="container">
                <div class="px-2 py-4 px-md-4 py-md-3 bg-white rounded">
                    <div class="d-flex flex-wrap mb-3 align-items-baseline justify-content-center">
                        <h3 class="h3 fw-700 mb-0">
                            <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Featured Categories') }}</span>
                        </h3>
                    </div>
                    <ul class="list-unstyled mb-0 row row-cols-xxl-5 row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-3 gutters-5 mt-3 featured-category-carousel">
                        @foreach ($featured_categories as $key => $category)
                            <li class="minw-0 pl-3 pr-3 mb-3">
                                <a href="{{ route('products.category', $category->slug) }}" class="d-block rounded text-center p-2 text-reset">
                                    <img
                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ uploaded_asset($category->banner) }}"
                                        alt="{{ $category->getTranslation('name') }}"
                                        class="lazyload img-fit h-50px h-md-70px h-lg-80px"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';"
                                    >
                                    <div class="fs-14 text-truncate fw-600 mt-2">{{ $category->getTranslation('name') }}
                                        <span class="mr-3">
                                            <i class="las la-arrow-right"></i>
                                        </span>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>
    @endif


    {{-- Banner Section 2
    @if (get_setting('home_banner2_images') != null)
    <div class="mb-4">
        <div class="container">
            <div class="row gutters-10">
                @php $banner_2_imags = json_decode(get_setting('home_banner2_images')); @endphp
                @foreach ($banner_2_imags as $key => $value)
                    <div class="col-xl col-md-6">
                        <div class="mb-3 mb-lg-0">
                            <a href="{{ json_decode(get_setting('home_banner2_links'), true)[$key] }}" class="mb-3 d-block text-reset">
                                <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset($banner_2_imags[$key]) }}" alt="{{ env('APP_NAME') }} promo" class="rounded img-fit lazyload">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif --}}


    {{-- Classified Product
        @if(get_setting('classified_product') == 1)
        @php
            $classified_products = \App\CustomerProduct::where('status', '1')->where('published', '1')->take(10)->get();
        @endphp
           @if (count($classified_products) > 0)
               <section class="mb-4">
                   <div class="container">
                       <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                            <div class="d-flex mb-3 align-items-baseline border-bottom">
                                <h3 class="h5 fw-700 mb-0">
                                    <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Classified Ads') }}</span>
                                </h3>
                                <a href="{{ route('customer.products') }}" class="ml-auto mr-0 btn btn-primary btn-sm shadow-md">{{ translate('View More') }}</a>
                            </div>
                           <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="5" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true'>
                               @foreach ($classified_products as $key => $classified_product)
                                   <div class="carousel-box">
                                        <div class="aiz-card-box border border-light rounded hov-shadow-md my-2 has-transition">
                                            <div class="position-relative">
                                                <a href="{{ route('customer.product', $classified_product->slug) }}" class="d-block">
                                                    <img
                                                        class="img-fit lazyload mx-auto h-140px h-md-210px"
                                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                        data-src="{{ uploaded_asset($classified_product->thumbnail_img) }}"
                                                        alt="{{ $classified_product->getTranslation('name') }}"
                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                    >
                                                </a>
                                                <div class="absolute-top-left pt-2 pl-2">
                                                    @if($classified_product->conditon == 'new')
                                                       <span class="badge badge-inline badge-success">{{translate('new')}}</span>
                                                    @elseif($classified_product->conditon == 'used')
                                                       <span class="badge badge-inline badge-danger">{{translate('Used')}}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="p-md-3 p-2 text-left">
                                                <div class="fs-15 mb-1">
                                                    <span class="fw-700 text-primary">{{ single_price($classified_product->unit_price) }}</span>
                                                </div>
                                                <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0 h-35px">
                                                    <a href="{{ route('customer.product', $classified_product->slug) }}" class="d-block text-reset">{{ $classified_product->getTranslation('name') }}</a>
                                                </h3>
                                            </div>
                                       </div>
                                   </div>
                               @endforeach
                           </div>
                       </div>
                   </div>
               </section>
           @endif
       @endif --}}
    
    {{-- New Arrivals --}}

    <section class="mb-4">
        <div class="container">
            <div class="px-2 py-4 px-md-4 py-md-3 new-arrivals rounded">
                <div class="d-flex mb-3 align-items-baseline justify-content-center">
                    <h3 class="h3 fw-700 mb-0">
                        <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('New Arrivals') }}</span>
                    </h3>
                </div>
                <div class="aiz-carousel gutters-10 slick-initialized slick-slider gutters-10">
                    <div class="slick-track" style="width: 100%;">
                        @php
                            $products = filter_products(\App\Product::where('published', 1))->orderBy('id', 'DESC')->take(10)->get();
                        @endphp
                        @foreach ($products as $key => $product)
                        <div class="slick-slide w-xl-20 w-lg-25 w-md-33 w-50">
                            <div>
                                <div class="carousel-box d-inline-block w-100">
                                    <div class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                                        <div class="position-relative">
                                            <a href="{{ route('product', $product->slug) }}" class="d-block">
                                                <img
                                                    class="img-fit lazyload mx-auto h-140px h-md-210px"
                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                    data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                    alt="{{  $product->getTranslation('name')  }}"
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                >
                                            </a>
                                            <div class="absolute-top-right aiz-p-hov-icon">
                                                <a href="javascript:void(0)" onclick="addToWishList({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to wishlist') }}" data-placement="left">
                                                    <i class="la la-heart-o"></i>
                                                </a>
                                                <a href="javascript:void(0)" onclick="addToCompare({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to compare') }}" data-placement="left">
                                                    <i class="las la-sync"></i>
                                                </a>
                                                <a href="javascript:void(0)" onclick="showAddToCartModal({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to cart') }}" data-placement="left">
                                                    <i class="las la-shopping-cart"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="p-md-3 p-2 text-left">
                                            <div class="fs-16">
                                                @if(home_base_price($product) != home_discounted_base_price($product))
                                                    <del class="fw-600 opacity-50 mr-1">{{ home_base_price($product) }}</del>
                                                @endif
                                                <span class="fw-700 text-primary">{{ home_discounted_base_price($product) }}</span>
                                            </div>
                                            <div class="rating rating-sm mt-1">
                                                {{ renderStarRating($product->rating) }}
                                            </div>
                                            <h3 class="fw-600 fs-14 text-truncate-2 lh-1-4 mb-0 h-35px">
                                                <a href="{{ route('product', $product->slug) }}" class="d-block text-reset">{{  $product->getTranslation('name')  }}</a>
                                            </h3>
                                            @if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated)
                                                <div class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                                                    {{ translate('Club Point') }}:
                                                    <span class="fw-700 float-right">{{ $product->earn_point }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="w-100 text-center">
                            <a href="{{ route('product.new_arrival') }}" class="mr-0 btn btn-primary btn-sm shadow-md">{{ translate('View more') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    {{-- Category wise Products --}}
    <div id="section_home_categories">

    </div>

    {{-- Best Seller
    @if (get_setting('vendor_system_activation') == 1)
    <div id="section_best_sellers">

    </div>
    @endif --}}

    
    {{-- Top 10 categories and Brands
    @if (get_setting('top10_categories') != null && get_setting('top10_brands') != null)
    <section class="mb-4">
        <div class="container">
            <div class="row gutters-10">
                @if (get_setting('top10_categories') != null)
                    <div class="col-lg-6">
                        <div class="d-flex mb-3 align-items-baseline border-bottom">
                            <h3 class="h3 fw-700 mb-0">
                                <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Top 10 Categories') }}</span>
                            </h3>
                            <a href="{{ route('categories.all') }}" class="ml-auto mr-0 btn btn-primary btn-sm shadow-md">{{ translate('View All Categories') }}</a>
                        </div>
                        <div class="row gutters-5">
                            @php $top10_categories = json_decode(get_setting('top10_categories')); @endphp
                            @foreach ($top10_categories as $key => $value)
                                @php $category = \App\Category::find($value); @endphp
                                @if ($category != null)
                                    <div class="col-sm-6">
                                        <a href="{{ route('products.category', $category->slug) }}" class="bg-white border d-block text-reset rounded p-2 hov-shadow-md mb-2">
                                            <div class="row align-items-center no-gutters">
                                                <div class="col-3 text-center">
                                                    <img
                                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                        data-src="{{ uploaded_asset($category->banner) }}"
                                                        alt="{{ $category->getTranslation('name') }}"
                                                        class="img-fluid img lazyload h-60px"
                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                    >
                                                </div>
                                                <div class="col-7">
                                                    <div class="text-truncat-2 pl-3 fs-14 fw-600 text-left">{{ $category->getTranslation('name') }}</div>
                                                </div>
                                                <div class="col-2 text-center">
                                                    <i class="la la-angle-right text-primary"></i>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
                @if (get_setting('top10_brands') != null)
                    <div class="col-lg-6">
                        <div class="d-flex mb-3 align-items-baseline border-bottom">
                            <h3 class="h3 fw-700 mb-0">
                                <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Top 10 Brands') }}</span>
                            </h3>
                            <a href="{{ route('brands.all') }}" class="ml-auto mr-0 btn btn-primary btn-sm shadow-md">{{ translate('View All Brands') }}</a>
                        </div>
                        <div class="row gutters-5">
                            @php $top10_brands = json_decode(get_setting('top10_brands')); @endphp
                            @foreach ($top10_brands as $key => $value)
                                @php $brand = \App\Brand::find($value); @endphp
                                @if ($brand != null)
                                    <div class="col-sm-6">
                                        <a href="{{ route('products.brand', $brand->slug) }}" class="bg-white border d-block text-reset rounded p-2 hov-shadow-md mb-2">
                                            <div class="row align-items-center no-gutters">
                                                <div class="col-4 text-center">
                                                    <img
                                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                        data-src="{{ uploaded_asset($brand->logo) }}"
                                                        alt="{{ $brand->getTranslation('name') }}"
                                                        class="img-fluid img lazyload h-60px"
                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                    >
                                                </div>
                                                <div class="col-6">
                                                    <div class="text-truncate-2 pl-3 fs-14 fw-600 text-left">{{ $brand->getTranslation('name') }}</div>
                                                </div>
                                                <div class="col-2 text-center">
                                                    <i class="la la-angle-right text-primary"></i>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    @endif --}}


    {{-- Video & Usefull links --}}

   <section class="mb-4">
    <div class="container">
        <div class="row gutters-10">
            <div class="col-xl-6">
                <div class="d-flex mb-3 align-items-baseline border-bottom">
                    <h3 class="h3 fw-700 mb-0">
                        <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Featured Video') }}</span>
                    </h3>
                    <a href="#" class="ml-auto mr-0 btn btn-dark btn-sm shadow-md">{{ translate('Watch more videos') }}</a>
                </div>
                <div class="row gutters-5">
                    <div class="col-sm-12">
                        <div class="featured_video mb-2">
                            <div id="featured_item__video" class="rounded featured_item__video h-220px h-md-280px" data-setbg="{{ static_asset('uploads/all/dDXqGwhxYgcEKjjiZYW0sLNnumhwVCjcnuYsxRMz.png') }}">
                                <a href="https://www.youtube.com/watch?v=NeCJeCozltA" class="play-btn video-popup btn-primary"><i class="las la-play text-white"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-xl-6">
                <div class="d-flex mb-3 align-items-baseline justify-content-center">
                    <h3 class="h3 fw-700 mb-0">
                        <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Quick Links') }}</span>
                    </h3>
                </div>
                <div class="row gutters-5">
                    <div class="col-sm-6">
                        <a href="https://motorsheba.com/blog/driving-instruction" class="bg-white quick-links border d-block text-reset rounded p-2 hov-shadow-md mb-2">
                            <div class="row align-items-center no-gutters">
                                <div class="col-4 text-center">
                                    <img
                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ static_asset('uploads/all/PRsiBT9ARFUMTCeLeZX1X4yS5dWdyQ5Q5oKDhOsr.png') }}"
                                        alt="Driving Instruction"
                                        class="p-3 img-fluid img lazyload h-60px"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                    >
                                </div>
                                <div class="col-6">
                                    <div class="text-truncate-2 pl-3 fs-14 fw-600 text-left">Driving Instruction</div>
                                </div>
                                <div class="col-2 text-center">
                                    <i class="la la-angle-right text-primary"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="https://motorsheba.com/blog/get-license" class="bg-white quick-links border d-block text-reset rounded p-2 hov-shadow-md mb-2">
                            <div class="row align-items-center no-gutters">
                                <div class="col-4 text-center">
                                    <img
                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ static_asset('uploads/all/8bc1dpf8CslTtsxUGfEi3VPf6bzz2F0xVUj8yecC.png') }}"
                                        alt="Get License"
                                        class="p-3 img-fluid img lazyload h-60px"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                    >
                                </div>
                                <div class="col-6">
                                    <div class="text-truncate-2 pl-3 fs-14 fw-600 text-left">Get License</div>
                                </div>
                                <div class="col-2 text-center">
                                    <i class="la la-angle-right text-primary"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="https://motorsheba.com/blog/road-rules" class="bg-white quick-links border d-block text-reset rounded p-2 hov-shadow-md mb-2">
                            <div class="row align-items-center no-gutters">
                                <div class="col-4 text-center">
                                    <img
                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ static_asset('uploads/all/W5rbAuVhAcfwaglDoVqzA4irnhbTQSOhnjRACIj6.png') }}"
                                        alt="Road Rules"
                                        class="p-3 img-fluid img lazyload h-60px"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                    >
                                </div>
                                <div class="col-6">
                                    <div class="text-truncate-2 pl-3 fs-14 fw-600 text-left">Road Rules</div>
                                </div>
                                <div class="col-2 text-center">
                                    <i class="la la-angle-right text-primary"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="https://motorsheba.com/blog/brta-instruction" class="bg-white quick-links border d-block text-reset rounded p-2 hov-shadow-md mb-2">
                            <div class="row align-items-center no-gutters">
                                <div class="col-4 text-center">
                                    <img
                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ static_asset('uploads/all/vnLKrbQXbB9iNS88FbtSomTSJlL4B04Pg3qyxJx0.png') }}"
                                        alt="BRTA Instruction"
                                        class="p-3 img-fluid img lazyload h-60px"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                    >
                                </div>
                                <div class="col-6">
                                    <div class="text-truncate-2 pl-3 fs-14 fw-600 text-left">BRTA Instruction</div>
                                </div>
                                <div class="col-2 text-center">
                                    <i class="la la-angle-right text-primary"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="#" class="bg-white quick-links border d-block text-reset rounded p-2 hov-shadow-md mb-2">
                            <div class="row align-items-center no-gutters">
                                <div class="col-4 text-center">
                                    <img
                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ static_asset('uploads/all/JQtsTKAvki0aJfdqPuio2PgD7sun0TVFEUwuarPt.png') }}"
                                        alt="Videos"
                                        class="p-3 img-fluid img lazyload h-60px"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                    >
                                </div>
                                <div class="col-6">
                                    <div class="text-truncate-2 pl-3 fs-14 fw-600 text-left">Videos</div>
                                </div>
                                <div class="col-2 text-center">
                                    <i class="la la-angle-right text-primary"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="https://bsp.brta.gov.bd/vehicleRegistration;jsessionid=FFB6B5DDF495B896CD75722377ABA12D.server4" class="bg-white quick-links border d-block text-reset rounded p-2 hov-shadow-md mb-2">
                            <div class="row align-items-center no-gutters">
                                <div class="col-4 text-center">
                                    <img
                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ static_asset('uploads/all/GBLdUD7wFcT9e6PbfxKIO4lXXy83uch2069lomSs.png') }}"
                                        alt="Application Link"
                                        class="p-3 img-fluid img lazyload h-60px"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                    >
                                </div>
                                <div class="col-6">
                                    <div class="text-truncate-2 pl-3 fs-14 fw-600 text-left">Application Link</div>
                                </div>
                                <div class="col-2 text-center">
                                    <i class="la la-angle-right text-primary"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Banner Section 3 --}}
@if (get_setting('home_banner3_images') != null)
<div class="mb-4">
    <div class="container">
        <div class="row gutters-10">
            @php $banner_3_imags = json_decode(get_setting('home_banner3_images')); @endphp
            @foreach ($banner_3_imags as $key => $value)
                <div class="col-xl col-md-6">
                    <div class="mb-3 mb-lg-0">
                        <a href="{{ json_decode(get_setting('home_banner3_links'), true)[$key] }}" class="mb-3 d-block text-reset">
                            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset($banner_3_imags[$key]) }}" alt="{{ env('APP_NAME') }} promo" class="rounded img-fit lazyload">
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js" integrity="sha512-IsNh5E3eYy3tr/JiX2Yx4vsCujtkhwl7SLqgnwLNgf04Hrt9BT9SXlLlZlWx+OK4ndzAoALhsMNcCmkggjZB1w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
        $(document).ready(function(){
            $.post('{{ route('home.section.featured') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_featured').html(data);
                AIZ.plugins.slickCarousel();
            });
            $.post('{{ route('home.section.best_selling') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_best_selling').html(data);
                AIZ.plugins.slickCarousel();
            });

            $.post('{{ route('home.section.home_categories') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_home_categories').html(data);
                AIZ.plugins.slickCarousel();
            });

            @if (get_setting('vendor_system_activation') == 1)
            $.post('{{ route('home.section.best_sellers') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_best_sellers').html(data);
                AIZ.plugins.slickCarousel();
            });
            @endif
            $('.all-brand-carousel').slick({
                  infinite: true,
                  slidesToShow: 5,
                  slidesToScroll: 3,
                  prevArrow:
                        '<button type="button" class="slick-prev"><i class="las la-angle-left"></i></button>',
                  nextArrow:
                        '<button type="button" class="slick-next"><i class="las la-angle-right"></i></button>',
                  responsive: [
                        {
                            breakpoint: 1500,
                            settings: {
                              slidesToShow: 5,
                              slidesToScroll: 3,
                            },
                        },
                        {
                            breakpoint: 1100,
                            settings: {
                              slidesToShow: 4,
                              slidesToScroll: 3,
                            },
                        },
                        {
                            breakpoint: 992,
                            settings: {
                              slidesToShow: 3,
                              slidesToScroll: 2,
                            },
                        },
                        {
                            breakpoint: 768,
                            settings: {
                              slidesToShow: 3,
                              slidesToScroll: 2,
                            },
                        },
                        {
                            breakpoint: 576,
                            settings: {
                              slidesToShow: 3,
                              slidesToScroll: 1,
                            },
                        },
                    ],
            });
        });
        $('#featured_item__video').each(function () {
        var bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
        });

        $('.video-popup').magnificPopup({
            type: 'iframe'
        });

        $('#manufacturer').on('change', function() {
            var manufacturer_id = $(this).val();
            if(manufacturer_id) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {manufacturer_id: manufacturer_id },
                    type: "POST",
                    url:'{{ route('search.compatibility.car_model') }}',
                    dataType: "json",
                    success:function(data) {
                        // console.log(data);
                        $('#car_model').empty();
                            $('#car_model').append('<option value="" class="fw-600">Select Model</option>')
                        $.each(data, function(key, value) {
                            $('#car_model').append('<option value="'+ value.id +'" class="fw-600">'+ value.model +'</option>');
                        });
                        AIZ.plugins.bootstrapSelect('refresh');
                    }
                });
            }
        });
    </script>
@endsection
