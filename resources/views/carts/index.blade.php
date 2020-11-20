@extends('layouts.app')


@section('content')

	<div class="container">
	<div class="row mx-auto">

	@foreach($carts as $cart)


		<div class="col-12 col-md-6 mt-3">
			<div onclick="window.location.assign('{{ url('service/'.$cart->service->id) }}')" class="card mx-auto" style="width: 18rem;">
				<form method="POST" action="{{ action('CartController@delete') }}">
					@csrf
					<input type="hidden" name="id" value="{{ $cart->id }}">
					<button class="btn btn-secondary p-0 pr-2 pl-2 border-0" style="position: absolute;right: 0;background-color: #d1363652;">X</button>
				</form>
			  <img class="card-img-top border" src="{{ asset('storage/'.$cart->service->img_path) }}" alt="Card image cap" style="width: 100%; height: 12rem;">
			  <div class="card-body" {{$rtl}}>
			    <p class="card-text">{{ str_limit($cart->service->title, 20) }} <a href="#">- {{ __('service.continue') }}</a></p>
			  </div>
			</div>
		</div>

	@endforeach
	</div>
	</div>
@endsection