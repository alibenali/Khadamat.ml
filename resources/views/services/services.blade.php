@extends('layouts/app')

@section('content')

<div class="container">
	@can('create', App\Service::class)
	<a href="{{ url('service/create') }}" class="btn btn-success">New Service</a>
	@endcan
	<div class="row justify-content-center">
	@foreach($services as $service)
		<div class="col">
			<a href="{{ url('service/'.$service->id.'') }}">
				<div class="card mx-auto mt-2" style="width: 14rem;">
				<img src="{{ asset('storage/'.$service->img_path.'') }}" class="img-fluid mw-50" alt="Responsive image" />
				<a href="{{ url('service/'.$service->id.'') }}" class="m-2 text-right text-dark" title="{{ $service->title }}">{{ $service->title }}</a>
				</div>
			</a>
		</div>
	@endforeach()
	</div>
</div>
@endsection()