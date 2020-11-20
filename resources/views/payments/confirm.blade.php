@extends('layouts.app')




@section('content')

<link rel="stylesheet" type="text/css" href="{{ asset('css/shopping-cart.css') }}">
<script type="text/javascript">
	
	function the_quantity(){

	var quantity = document.getElementById("quantity").value;
	var price = {{ $service->price }};
	var fees = {{ $service->fees }};
	var acc_bal = {{$balance}};

	var total = document.getElementById("price").innerHTML = (price*quantity)+fees;
	var new_bal= document.getElementById("new_bal").innerHTML = acc_bal-total;

	
			new_bal= document.getElementById("new_bal").innerHTML = total;
			new_bal= document.getElementById("msj").innerHTML = "";
			$('button').prop('disabled', false);

	}

</script>
<main class="page">
	 	<section class="shopping-cart ">
	 		<div class="container">
		        <div class="block-heading">
		          <h2>{{ __('payment.shoppingCart') }}</h2>
		          
				@if(session()->has('success'))
		            <div class="alert alert-success">
		                {{ session()->get('success') }}
		            </div>
		        @endif

		        @if ($errors->any())
		        	<div class="alert alert-danger">
		        	<ul>
					@foreach($errors->all() as $error)
						 <li class="text-left">{{$error}} </li>
					@endforeach
					</ul>
					</div>
				@endif

		        </div>
		        <div class="content">
		        	<form action="{{ url('payment') }}" method="POST">
		        		@csrf
	 				<div class="row" {{$rtl}}>
	 					<div class="col-md-12 col-lg-8">
	 						<div class="items">
				 				<div class="product card-body">
				 					<h5> <a href="{{ url('service/'.$service->id.'') }}"> {{ str_limit($service->title, 50) }} </a></h5>
				 					<div class="row">
					 					<div class="col-md-3">
					 						<img class="img-fluid mx-auto d-block image m-4" src="{{ asset('storage/'.$service->img_path.'') }}">
					 					</div>
					 					<div class="col-md-8">
					 						<div class="info">


														<div class="form-group row" >
							 							<label for="quantity" class="col-2 col-form-label ml-2 mr-2"> {{ __('payment.quantity') }} </label>
							 							<div class="col-4">
							 							<select id="quantity" class="form-control" name="quantity" onchange="the_quantity();">
							 								{{ $i = 0 }}
							 								@while($i != $service->remaining)
							 								{{ $i++ }}
							 								<option value="{{ $i }}">{{ $i }}</option>
							 								@endwhile
							 							</select>
														<h5 class="text-center mt-2"> <a id="price">{{ $service->price }}</a> {{ __('currency.'.$service->currency) }} </h5>

							 						    </div>
							 							</div>

							 						
							 				</div>
					 					</div>
					 				</div>
				 				</div>
				 			</div>
			 			</div>
			 			<div class="col-md-12 col-lg-4">
			 				<div class="summary">
			 					<h3>{{ __('payment.summary') }}</h3>
			 					<table class="w-100 {{$tdir}}" {{ $rtl }}>
											<tbody>
												<tr>
													<td><a class="font-weight-bold">{{ __('payment.accountBalance') }}</a> : </td>
													<td>{{ $balance }} {{ __('currency.'.$service->currency) }}</td>
												</tr>

												<tr>
													<td><a class="font-weight-bold"><a id="price">{{ __('payment.price') }}</a> ({{ $service->p_method }})</a>: </td>
													<td>{{ $service->price }} {{ __('currency.'.$service->currency) }}</td>
												</tr>

												<tr>
													<td><a class="font-weight-bold">{{ __('payment.fees') }}</a> : </td>
													<td>{{ $service->fees }} {{ __('currency.'.$service->currency) }}</td>
												</tr>

												<tr>
													<td><a class="font-weight-bold" >{{ __('payment.total') }}</a> : </td>
													<td><a id="new_bal">{{ $total }}</a> {{ __('currency.'.$service->currency) }}</td>
												</tr>

											</tbody>
								</table>
								<input type="hidden" name="service_id" value="{{ $service->id }}">
								<button type="submit" id="button" class="btn btn-primary btn-lg btn-block" {{ $status }}>{{ __('payment.checkout') }}</button>
								<a id="msj" class="text-danger float-{{$dir}}">{{ __('payment.'.$msj)}}</a>

				 			</div>
			 			</div>
		 			</div> 
		 			</form>
		 		</div>
	 		</div>
		</section>
	</main>



@endsection