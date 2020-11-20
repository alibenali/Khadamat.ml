@extends('layouts.app')


@section('content')


<div class="container">

	<div class="pt-1 pl-3 pr-3">
		<label for="title"><h5 class="font-weight-bold">Service Title</h5></label>
		<input id="title" class="form-control" value="{{ $service->title }}" readonly="" />
		<hr>
	</div>

	<div class="pt-1 pl-3 pr-3">
		<label for="category"><h5 class="font-weight-bold">Service category</h5></label>
		<input id="category" class="form-control" value="{{ $service->category }}" readonly="" />
		<hr>
	</div>

	<div class="pt-1 pl-3 pr-3">
		<label for="subcategory"><h5 class="font-weight-bold">Service subcategory</h5></label>
		<input id="subcategory" class="form-control" value="{{ $service->sub_category }}" readonly="" />
		<hr>
	</div>



	<div class="pt-1 pl-3 pr-3">
		<label for="price"><h5 class="font-weight-bold">Service price</h5></label>
		<input id="price" class="form-control" value="{{ $service->price }} {{ $service->currency }}" readonly="" />
		<hr>
	</div>

	<div class="pt-1 pl-3 pr-3">
		<label for="fees"><h5 class="font-weight-bold">Service fees</h5></label>
		<input id="fees" class="form-control" value="{{ $service->fees }}" readonly="" />
		<hr>
	</div>

	<div class="pt-1 pl-3 pr-3">
		<label for="p_method"><h5 class="font-weight-bold">Service p_method</h5></label>
		<input id="p_method" class="form-control" value="{{ $service->p_method }}" readonly="" />
		<hr>
	</div>

	<div class="pt-1 pl-3 pr-3">
		<label for="currency"><h5 class="font-weight-bold">Service currency</h5></label>
		<input id="currency" class="form-control" value="{{ $service->currency }}" readonly="" />
		<hr>
	</div>

	<div class="pt-1 pl-3 pr-3">
		<label for="duration"><h5 class="font-weight-bold">Service duration</h5></label>
		<input id="duration" class="form-control" value="{{ $service->duration }}" readonly="" />
		<hr>
	</div>

	<div class="pt-1 pl-3 pr-3">
		<label for="purchases"><h5 class="font-weight-bold">Service purchases</h5></label>
		<input id="purchases" class="form-control" value="{{ $service->purchases_number }}" readonly="" />
		<hr>
	</div>

	<div class="pt-1 pl-3 pr-3">
		<label for="remaining"><h5 class="font-weight-bold">Service remaining</h5></label>
		<input id="remaining" class="form-control" value="{{ $service->remaining }}" readonly="" />
		<hr>
	</div>

	<div class="pt-1 pl-3 pr-3">
		<label for="rates"><h5 class="font-weight-bold">Service number rates</h5></label>
		<input id="rates" class="form-control" value="{{ $service->num_raters }}" readonly="" />
		<hr>
	</div>

	<div class="pt-1 pl-3 pr-3">
		<label for="status"><h5 class="font-weight-bold">Service status</h5></label>
		<input id="status" class="form-control" value="{{ $service->the_status }}" readonly="" />
		<hr>
	</div>

	<div class="pt-1 pl-3 pr-3">
		<label for="created"><h5 class="font-weight-bold">Service created at</h5></label>
		<input id="created" class="form-control" value="{{ $service->created_at }}" readonly="" />
		<hr>
	</div>

	<div class="pt-1 pl-3 pr-3">
		<label for="updated"><h5 class="font-weight-bold">Service updated at</h5></label>
		<input id="updated" class="form-control" value="{{ $service->updated_at }}" readonly="" />
		<hr>
	</div>

	<div class="pt-1 pl-3 pr-3">
		<label for="Description"><h5 class="font-weight-bold">Service Description</h5></label>
		{!! $service->description !!}
		<hr>
	</div>

</div>

@endsection