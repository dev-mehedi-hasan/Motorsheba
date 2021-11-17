<div class="aiz-category-menu bg-white rounded @if(Route::currentRouteName() == 'home') shadow-sm" @else shadow-lg" id="category-sidebar" @endif>
    <div class="p-3 bg-primary d-none d-xl-block rounded-top all-category position-relative text-white text-left">
        <span class="fw-600 h5 ml-2 mr-3"><i class="lab la-buromobelexperte"></i></span>
        <span class="fw-600 h5 ml-2 mr-3">{{ translate('Japanese Parts') }}</span>
        {{-- <a href="{{ route('categories.all') }}" class="text-reset">
            <span class="d-none d-lg-inline-block">{{ translate('See All') }} ></span>
        </a> --}}
    </div>
    <ul class="c-scrollbar-light overflow-auto list-unstyled japanese-parts-category py-2 mb-0 text-left">
        @php
            $seller_user = \App\User::where('user_type', 'seller')->where('name', 'LIKE', '%RT Fronuse%')->first(); 
        @endphp
        @foreach (\App\Category::where('level', 0)->orderBy('order_level', 'desc')->get() as $key => $category)
            <li class="category-nav-element hov-bg-soft-primary" data-id="{{ $category->id }}">
                <a href="{{ route('products.category.seller' ,['category_slug'=>$category->slug,'seller_user_id'=>$seller_user->id]) }}" class="text-truncate text-reset px-2 d-block h6 fw-600">
                    <img
                        class="cat-image lazyload mr-2"
                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                        data-src="{{ uploaded_asset($category->icon) }}"
                        width="50"
                        alt="{{ $category->getTranslation('name') }}"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                    >
                    <span class="cat-name">{{ $category->getTranslation('name') }}</span>
                </a>
                @if(count(\App\Utility\CategoryUtility::get_immediate_children_ids($category->id))>0)
                    <div class="sub-cat-menu c-scrollbar-light rounded shadow-lg p-4">
                        <div class="c-preloader text-center absolute-center">
                            <i class="las la-spinner la-spin la-3x"></i>
                        </div>
                    </div>
                @endif
            </li>
        @endforeach
    </ul>
</div>
