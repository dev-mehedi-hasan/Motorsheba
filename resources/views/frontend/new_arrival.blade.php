@extends('frontend.layouts.app')

@section('content')
<section class="pt-4 mb-4">
    <div class="container text-center">
        <div class="row">
            <div class="col-lg-6 text-center text-lg-left">
                <h1 class="fw-600 h3">{{ translate('Latest Products') }}</h1>
            </div>
            <div class="col-lg-6">
                <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">
                    <li class="breadcrumb-item opacity-50">
                        <a class="text-reset" href="{{ route('home') }}">{{ translate('Home')}}</a>
                    </li>
                    <li class="text-dark fw-600 breadcrumb-item">
                        <a class="text-reset" href="{{ route('product.new_arrival') }}">"{{ translate('New Arrivals') }}"</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
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
                        $products = filter_products(\App\Product::where('published', 1))->orderBy('id', 'DESC')->paginate(20);
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
                    <div class="slick-slide w-100 text-center product-pagination">
                        {!! $products->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection