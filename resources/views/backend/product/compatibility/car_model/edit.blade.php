@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <h5 class="mb-0 h6">{{translate('Car Model Information')}}</h5>
</div>

<div class="col-lg-8 mx-auto">
    <div class="card">
        <div class="card-body p-0">
            <form class="p-4" action="{{ route('compatibility.car_model.update', $car_model->id) }}" method="POST">
                <input name="_method" type="hidden" value="PATCH">
                @csrf
                <div class="form-group row mb-3 align-items-center">
                    <label for="manufacturer_id" class="col-sm-3 from-label">{{translate('Manufacturer')}}</label>
                    <div class="col-sm-9">
                        <select class="select2 form-control aiz-selectpicker" name="manufacturer_id" data-toggle="select2" data-placeholder="Choose ..." data-live-search="true">
                            @foreach ($manufacturers as $manufacturer)
                                <option value="{{$manufacturer->id}}" @if($manufacturer->id == $car_model->manufacturer_id) selected @endif>{{$manufacturer->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label class="col-sm-3 from-label" for="model">{{translate('Car Model')}} </label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Model')}}" id="model" name="model" value="{{ $car_model->model }}" class="form-control" required>
                    </div>
                </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
