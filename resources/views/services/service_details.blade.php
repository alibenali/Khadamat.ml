@extends('layouts/app')

@section('content')


<style type="text/css">
span.badge.pull-left {
    margin-right: 10px;
}

</style>

<div class="container">


	<div class="row">	
		<div class="col" style="min-width: 250px;">

			<div class="card mt-2">

			<h4 class="font-weight-bold pt-4 pl-4 pr-4 mb-3">{{ $service->title }}</h4>
			<hr align="center" width="92%" class="mx-auto m-0">

			  <ol class="breadcrumb bg-white pl-4 pr-4 mb-4">
			    <li class="breadcrumb-item"><a href="#">Home</a></li>
			    <li class="breadcrumb-item active" aria-current="page">Library</li>
			  </ol>

			<img src="{{asset('storage/'.$service->img_path.'')}}" class="img-fluid" alt="Responsive image" />
			</div>
		</div>

		<div class="col-lg-5 pt-2"> 

		<div class="card">
			<div class="card-body">

			<!-- Price -->
			<h3 class="font-weight-bold">	{{ $service->price }} {{ $service->currency }}</h3>

			<!-- Payment method & Duration -->
			<div class="row mt-4">
				<div class="col">
					<p><i class=" fas fa-money-check-alt text-muted pr-2"></i> <a class="font-weight-bold">PAy with {{ $service->p_method }}</a></p>
				</div>
				<div class="col">
				<p><i class="far fa-clock pr-2"></i> <a class="font-weight-bold">{{ $service->duration }} Day duration</a></p>
				</div>
			</div>

			<!-- Description -->
			<p>{!! $service->description !!}</p>

			<!-- Continue button -->
			<div class="col text-center w-50 mx-auto">
				<button onclick="window.location.assign('{{ url('payment/confirm/'.$service->id.'') }}')" class="btn btn-lg btn-dark btn-block mx-auto">Continue</button>
			</div>

			</div>
		</div>


		</div>
	</div>

</div>
@endsection()