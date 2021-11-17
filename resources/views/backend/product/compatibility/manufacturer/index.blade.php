@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="align-items-center">
			<h1 class="h3">{{translate('All Manufacturers')}}</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="card">
		    <div class="card-header row gutters-5">
				<div class="col text-center text-md-left">
					<h5 class="mb-md-0 h6">{{ translate('Manufacturers') }}</h5>
				</div>
				<div class="col-md-4">
					<form class="" id="sort_manufacturers" action="" method="GET">
						<div class="input-group input-group-sm">
					  		<input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type name & Enter') }}">
						</div>
					</form>
				</div>
		    </div>
		    <div class="card-body">
		        <table class="table aiz-table mb-0">
		            <thead>
		                <tr>
		                    <th>#</th>
		                    <th>{{translate('Name')}}</th>
		                    <th class="text-right">{{translate('Options')}}</th>
		                </tr>
		            </thead>
		            <tbody>
		                @foreach($manufacturers as $key => $manufacturer)
		                    <tr>
		                        <td>{{ ($key+1) + ($manufacturers->currentPage() - 1)*$manufacturers->perPage() }}</td>
		                        <td>{{ $manufacturer->name }}</td>
		                        <td class="text-right">
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('compatibility.manufacturer.edit', $manufacturer->id)}}" title="{{ translate('Edit') }}">
		                                <i class="las la-edit"></i>
		                            </a>
		                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('compatibility.manufacturer.destroy', $manufacturer->id)}}" title="{{ translate('Delete') }}">
		                                <i class="las la-trash"></i>
		                            </a>
		                        </td>
		                    </tr>
		                @endforeach
		            </tbody>
		        </table>
		        <div class="aiz-pagination">
                	{{ $manufacturers->appends(request()->input())->links() }}
            	</div>
		    </div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h5 class="mb-0 h6">{{ translate('Add New Manufacturer') }}</h5>
			</div>
			<div class="card-body">
				<form action="{{ route('compatibility.manufacturer.store') }}" method="POST">
					@csrf
					<div class="form-group mb-3 {{ $errors->has('name') ? 'has-error' : '' }}">
						<label for="name">{{translate('Name')}}</label>
                        <input type="text" placeholder="{{translate('Name')}}" name="name" class="form-control" value="@if(old('name') != null) {{ old('name') }} @endif" required>
                        <span class="text-danger">{{ $errors->first('name') }}</span>
					</div>

					<div class="form-group mb-3 text-right">
						<button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
<script type="text/javascript">
    function sort_manufacturers(el){
        $('#sort_manufacturers').submit();
    }
</script>
@endsection
