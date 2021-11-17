@if(get_setting('topbar_banner') != null)

<div class="position-relative top-banner removable-session z-1035 d-none" data-key="top-banner" data-value="removed">

    <a href="{{ get_setting('topbar_banner_link') }}" class="d-block text-reset">

        <img src="{{ uploaded_asset(get_setting('topbar_banner')) }}" class="w-100 mw-100 h-50px h-lg-50px img-fit">

    </a>

    <button class="btn btn-sm text-white absolute-top-right set-session" data-key="top-banner" data-value="removed" data-toggle="remove-parent" data-parent=".top-banner">

        <i class="la la-close la-2x"></i>

    </button>

</div>

@endif

<!-- Top Bar -->

<div class="top-navbar bg-soft-primary border-bottom border-soft-secondary z-1035">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-lg-7 col">

                <ul class="list-inline text-center text-md-left mb-0">

                    @if(get_setting('show_language_switcher') == 'on')

                    <li class="list-inline-item dropdown mr-3" id="lang-change">

                        @php

                            if(Session::has('locale')){

                                $locale = Session::get('locale', Config::get('app.locale'));

                            }

                            else{

                                $locale = 'en';

                            }

                        @endphp

                        <a href="javascript:void(0)" class="dropdown-toggle text-reset py-2" data-toggle="dropdown" data-display="static">

                            <img src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ static_asset('assets/img/flags/'.$locale.'.png') }}" class="mr-2 lazyload" alt="{{ \App\Language::where('code', $locale)->first()->name }}" height="11">

                            <span class="opacity-100">{{ \App\Language::where('code', $locale)->first()->name }}</span>

                        </a>

                        <ul class="dropdown-menu dropdown-menu-left">

                            @foreach (\App\Language::all() as $key => $language)

                                <li>

                                    <a href="javascript:void(0)" data-flag="{{ $language->code }}" class="dropdown-item @if($locale == $language) active @endif">

                                        <img src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" class="mr-1 lazyload" alt="{{ $language->name }}" height="11">

                                        <span class="language">{{ $language->name }}</span>

                                    </a>

                                </li>

                            @endforeach

                        </ul>

                    </li>

                    @endif



                    @if(get_setting('show_currency_switcher') == 'on')

                    <li class="list-inline-item dropdown" id="currency-change">

                        @php

                            if(Session::has('currency_code')){

                                $currency_code = Session::get('currency_code');

                            }

                            else{

                                $currency_code = \App\Currency::findOrFail(get_setting('system_default_currency'))->code;

                            }

                        @endphp

                        <a href="javascript:void(0)" class="dropdown-toggle text-reset py-2 opacity-100" data-toggle="dropdown" data-display="static">

                            {{ \App\Currency::where('code', $currency_code)->first()->name }} {{ (\App\Currency::where('code', $currency_code)->first()->symbol) }}

                        </a>

                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">

                            @foreach (\App\Currency::where('status', 1)->get() as $key => $currency)

                                <li>

                                    <a class="dropdown-item @if($currency_code == $currency->code) active @endif" href="javascript:void(0)" data-currency="{{ $currency->code }}">{{ $currency->name }} ({{ $currency->symbol }})</a>

                                </li>

                            @endforeach

                        </ul>

                    </li>

                    @endif
                    <li class="list-inline-item mr-3">
                        <a class="text-reset py-2 d-inline-block opacity-100" href="mailto:info@motorsheba.com">
                            <span><i class="las la-envelope text-primary"></i></span>
                            <span class="hov-text-primary">info@motorsheba.com</span>
                        </a>
                    </li>
                    <li class="list-inline-item mr-3">
                        <a class="text-reset py-2 d-inline-block opacity-100" href="tel:+8809610-500500">
                            <span><i class="las la-mobile text-primary"></i></span>
                            <span class="hov-text-primary">(+880) 9610-500500</span>
                        </a>
                    </li>
                </ul>

            </div>

            <div class="col-5 text-right d-none d-lg-block">

                <ul class="list-inline mb-0">

                    @auth

                        @if(isAdmin())

                            <li class="list-inline-item mr-3">

                                <a href="{{ route('admin.dashboard') }}" class=" text-reset py-2 d-inline-block opacity-100">{{ translate('My Panel')}}</a>

                            </li>

                        @else

                            <li class="list-inline-item mr-3">

                                <a href="{{ route('dashboard') }}" class=" text-reset py-2 d-inline-block opacity-100">{{ translate('My Panel')}}</a>

                            </li>

                        @endif

                        <li class="list-inline-item">

                            <a href="{{ route('logout') }}" class=" text-reset py-2 d-inline-block opacity-100">{{ translate('Logout')}}</a>

                        </li>

                    @else

                        <li class="list-inline-item mr-3">

                            <a href="{{ route('user.login') }}" class=" text-reset py-2 d-inline-block opacity-100">{{ translate('Login')}}</a>

                        </li>

                        <li class="list-inline-item">

                            <a href="{{ route('user.registration') }}" class=" text-reset py-2 d-inline-block opacity-100">{{ translate('Registration')}}</a>

                        </li>

                    @endauth

                </ul>

            </div>

        </div>

    </div>

</div>

<!-- END Top Bar -->

<header class="@if(get_setting('header_stikcy') == 'on') sticky-top @endif z-1020 bg-white border-bottom shadow-sm">

    <div class="position-relative logo-bar-area z-1">

        <div class="container">

            <div class="d-flex align-items-center">



                <div class="col-auto col-xl-3 pl-0 pr-3 d-flex justify-content-between align-items-center">

                    <a class="d-block py-20px mr-3 ml-0" href="{{ route('home') }}">

                        @php

                            $header_logo = get_setting('header_logo');

                        @endphp

                        @if($header_logo != null)

                            <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}" class="mw-100 h-40px h-xxl-50px h-lg-40px" height="40">

                        @else

                            <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}" class="mw-100 h-40px h-xxl-50px h-lg-40px" height="40">

                        @endif
                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="Bangladesh-Japan">
                            <img src="{{ static_asset('uploads/all/M7Y50srrfxetHWuWwucUxXvy91DxDR52ZVSAUCEM.png') }}" class="h-xxl-40px h-30px lazyload" alt="" >
                            <img src="{{ static_asset('uploads/all/r0342oiJDm8xSft2L3kWzkSQEwGJfusytqOMJmzP.png') }}" class="h-xxl-40px h-30px lazyload" alt="" >
                        </a>

                    </a>



                    {{-- @if(Route::currentRouteName() != 'home')

                        <div class="d-none d-xl-block align-self-stretch category-menu-icon-box ml-auto mr-0">

                            <div class="h-100 d-flex align-items-center" id="category-menu-icon">

                                <div class="dropdown-toggle navbar-light bg-light h-40px w-50px pl-2 rounded border c-pointer">

                                    <span class="navbar-toggler-icon"></span>

                                </div>

                            </div>

                        </div>

                    @endif --}}

                </div>

                <div class="d-lg-none ml-auto mr-0">

                    <a class=" p-2 d-block text-reset" href="javascript:void(0);" data-toggle="class-toggle" data-target=".front-header-search">

                        <i class="las la-search la-flip-horizontal la-2x"></i>

                    </a>

                </div>



                <div class="flex-grow-1 front-header-search d-flex align-items-center bg-white">

                    <div class="position-relative flex-grow-1">

                        <form action="{{ route('search') }}" method="GET" class="stop-propagation">

                            <div class="d-flex position-relative align-items-center">

                                <div class="d-lg-none" data-toggle="class-toggle" data-target=".front-header-search">

                                    <button class="btn px-2" type="button"><i class="la la-2x la-long-arrow-left"></i></button>

                                </div>

                                <div class="input-group">

                                    <input type="text" class=" border-0 border-lg form-control" id="search" name="q" placeholder="{{translate('I am searching for...')}}" autocomplete="off">

                                    <div class="input-group-append d-none d-lg-block">

                                        <button class="btn btn-primary" type="submit">

                                            <i class="la la-search la-flip-horizontal fs-18"></i>

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </form>

                        <div class="typed-search-box stop-propagation document-click-d-none d-none bg-white rounded shadow-lg position-absolute left-0 top-100 w-100" style="min-height: 200px">

                            <div class="search-preloader absolute-top-center">

                                <div class="dot-loader"><div></div><div></div><div></div></div>

                            </div>

                            <div class=" search-nothing d-none p-3 text-center fs-16">



                            </div>

                            <div id="search-content" class=" text-left">



                            </div>

                        </div>

                    </div>

                </div>



                <div class="d-none d-lg-none ml-3 mr-0">

                    <div class="nav-search-box">

                        <a href="#" class=" nav-box-link">

                            <i class="la la-search la-flip-horizontal d-inline-block nav-box-icon"></i>

                        </a>

                    </div>

                </div>



                <div class="d-none d-lg-block  align-self-stretch ml-3 mr-0" data-hover="dropdown">

                    <div class="nav-cart-box dropdown h-100" id="cart_items">

                        @include('frontend.partials.cart')

                    </div>

                </div>



                <div class="d-none d-lg-block ml-3 mr-0">

                    <div class="" id="wishlist">

                        @include('frontend.partials.wishlist')

                    </div>

                </div>


                <div class="d-none d-lg-block ml-3 mr-0">

                    <div class="" id="compare">

                        @include('frontend.partials.compare')

                    </div>

                </div>


            </div>

        </div>

        {{-- @if(Route::currentRouteName() != 'home')

        <div class="hover-category-menu position-absolute w-100 top-100 left-0 right-0 d-none z-3" id="hover-category-menu">

            <div class="container">

                <div class="row gutters-10 position-relative">

                    <div class="col-lg-3 position-static">

                        @include('frontend.partials.category_menu')

                    </div>

                </div>

            </div>

        </div>

        @endif --}}

    </div>

    @if ( get_setting('header_menu_labels') !=  null )

        <div class="main-menu bg-white rounded border-gray-200 py-1">

            <div class="container">
                <div class="row gutters-10 align-items-center">
                    <div class="col-xl-3">
                        <div class="d-none d-xl-block align-self-stretch category-menu-icon-box ml-auto mr-0 bg-primary rounded">

                            <div class="h-100 d-flex align-items-center" id="category-menu-icon">

                                <div class="dropdown-toggle w-100 text-white p-3 justify-content-between">
                                    <a href="javascript:void(0);" class="h5 m-0 text-white">
                                        <span class="ml-2 mr-3 fw-600">
                                            <i class="las la-bars"></i>
                                        </span>
                                        <span class="ml-2 fw-600">
                                            Editor's Pick
                                        </span>
                                    </a>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="col-xl-5 col-md-6">
                        <ul class="first-ul list-inline mb-0 pl-0 text-center text-md-left mobile-hor-swipe">

                            @foreach (json_decode( get_setting('header_menu_labels'), true) as $key => $value)
        
                            <li class="list-inline-item mr-0">
        
                                <a href="{{ json_decode( get_setting('header_menu_links'), true)[$key] }}" class="hov-text-primary fw-600 opacity-100 fs-16 px-3 py-2 d-inline-block  text-reset">
        
                                    {{ translate($value) }}
        
                                </a>
        
                            </li>
        
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <ul class="second-ul list-inline mb-0 pl-0 text-center text-md-right">
                            <li class="list-inline-item mb-2 mb-md-0 mr-0 w-100 w-md-auto">
                                <a href="{{ route('product.inquiry') }}" class="px-3 fs-16 btn btn-sm btn-outline-dark shadow-md w-100">Product Inquiry</a>
                            </li>
                            <li class="list-inline-item mr-0 w-100 w-md-auto">
                                <a href="{{ route('orders.track') }}" class="px-3 fs-16 btn btn-sm btn-outline-primary shadow-md w-100">Order Tracking</a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="hover-category-menu position-absolute w-100 top-101 left-0 right-0 d-none z-3 pt-1" id="hover-category-menu">

                    <div class="container">

                        <div class="row gutters-10 position-relative">

                            <div class="col-lg-3 position-static">

                                @include('frontend.partials.category_menu')

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    @endif

</header>
