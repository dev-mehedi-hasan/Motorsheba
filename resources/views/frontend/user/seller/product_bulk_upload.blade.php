@extends('frontend.layouts.user_panel')

@section('panel_content')

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Product Bulk Upload')}}</h5>
        </div>
        <div class="card-body">
            <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                <strong>{{ translate('Step 1')}}:</strong>
                <p>1. {{translate('Download the skeleton file and fill it with proper data')}}.</p>
                <p>2. {{translate('You can download the example file to understand how the data must be filled')}}.</p>
                <p>3. {{translate('Once you have downloaded and filled the skeleton file, upload it in the form below and submit')}}.</p>
            </div>
            <br>
            <div class="">
                <a href="{{ static_asset('download/product_bulk_demo.xlsx') }}" download><button class="btn btn-info">{{ translate('Download CSV')}}</button></a>
            </div>
            <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                <strong>{{translate('Step 2')}}:</strong>
                <p>1. {{translate('Seller, Category, Brand, Photos, Thumbnail, PDF Specification, Manufacturing Year,Manufacturer and Car Models should be in numerical id')}}.</p>
                <p>2. {{translate('You can download the pdf to get them from below')}}.</p>
            </div>
            <br>
            <div class="row">
                <a class="col-sm-6 col-md-4 col-lg-3 col-12 mb-2" href="{{ route('pdf.download_seller') }}"><button class="btn btn-info">{{translate('Download Seller')}}</button></a>
                <a class="col-sm-6 col-md-4 col-lg-3 col-12 mb-2" href="{{ route('pdf.download_category') }}"><button class="btn btn-info">{{translate('Download Category')}}</button></a>
                <a class="col-sm-6 col-md-4 col-lg-3 col-12 mb-2" href="{{ route('pdf.download_brand') }}"><button class="btn btn-info">{{translate('Download Brand')}}</button></a>
                <a class="col-sm-6 col-md-4 col-lg-3 col-12 mb-2" href="{{ route('pdf.download_photo') }}"><button class="btn btn-info">{{translate('Download Photo')}}</button></a>
                <a class="col-sm-6 col-md-4 col-lg-3 col-12 mb-2" href="{{ route('pdf.download_pdf') }}"><button class="btn btn-info">{{translate('Download PDF')}}</button></a>
                <a class="col-sm-6 col-md-4 col-lg-3 col-12 mb-2" href="{{ route('pdf.download_manufacturing_year') }}"><button class="btn btn-info">{{translate('Download Manufacturing Year')}}</button></a>
                <a class="col-sm-6 col-md-4 col-lg-3 col-12 mb-2" href="{{ route('pdf.download_manufacturer') }}"><button class="btn btn-info">{{translate('Download Manufacturer')}}</button></a>
                <a class="col-sm-6 col-md-4 col-lg-3 col-12 mb-2" href="{{ route('pdf.download_car_model') }}"><button class="btn btn-info">{{translate('Download Car Model')}}</button></a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6"><strong>{{translate('Upload Product File')}}</strong></h5>
        </div>
        <div class="card-body">
            <form class="form-horizontal" action="{{ route('bulk_product_upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-sm-9">
                        <div class="custom-file">
    						<label class="custom-file-label">
    							<input type="file" name="bulk_file" class="custom-file-input" required>
    							<span class="custom-file-name">{{ translate('Choose File')}}</span>
    						</label>
    					</div>
                    </div>
                </div>
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-info">{{translate('Upload CSV')}}</button>
                </div>
            </form>
        </div>
    </div>

@endsection