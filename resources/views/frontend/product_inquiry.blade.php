@extends('frontend.layouts.app')

@section('content')
<section class="pt-4 mb-4">
    <div class="container text-center">
        <div class="row">
            <div class="col-lg-6 text-center text-lg-left">
                <h1 class="fw-600 h4">{{ translate('Product Inquiry') }}</h1>
            </div>
            <div class="col-lg-6">
                <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">
                    <li class="breadcrumb-item opacity-50">
                        <a class="text-reset" href="{{ route('home') }}">{{ translate('Home') }}</a>
                    </li>
                    <li class="text-dark fw-600 breadcrumb-item">
                        <a class="text-reset" href="{{ route('product.inquiry') }}">"{{ translate('Product Inquiry') }}"</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="mb-5">
    <div class="container text-left">
        <div class="row">
            <div class="col-xxl-5 col-xl-6 col-lg-8 mx-auto">
                <form class="" action="{{ route('orders.track') }}" method="GET" enctype="multipart/form-data">
                    <div class="bg-white rounded shadow-sm">
                        <div class="fs-15 fw-600 p-3 border-bottom text-center">
                            {{ translate('Select product attached your query')}}
                        </div>
                        <div class="form-box-content p-3">
                            <div class="form-group">
                                <label for="product_id">{{translate('All Products')}}</label>
                                <select class="select2 form-control aiz-selectpicker" name="product_id" data-toggle="select2" data-placeholder="Choose ..." data-live-search="true">
                                    @foreach ($products_out_of_stock as $product_out_of_stock)
                                        <option value="{{$product_out_of_stock->id}}">{{$product_out_of_stock->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="product_id">{{translate('Query')}}</label>
                                <textarea class="aiz-text-editor" name="query"></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">{{ translate('Submit')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
