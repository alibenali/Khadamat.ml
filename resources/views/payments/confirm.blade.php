@extends('layouts.app')




@section('content')

<link rel="stylesheet" type="text/css" href="{{ asset('css/shopping-cart.css') }}">
<script type="text/javascript">
	
	function the_quantity(){

	var quantity = document.getElementById("quantity").value;
	var price = {{ $service->price }};
	var acc_bal = {{$balance}};

	var new_price = document.getElementById("price").innerHTML = price*quantity;
	var new_bal= document.getElementById("new_bal").innerHTML = acc_bal-new_price;

		if(new_bal < 0){
			new_bal= document.getElementById("new_bal").innerHTML = "Impossible";
			new_bal= document.getElementById("msj").innerHTML = "Sorry, you don't have enough balance";
			$('button').prop('disabled', true);
		}else{
			new_bal= document.getElementById("msj").innerHTML = "";
			$('button').prop('disabled', false);
		}

	}

</script>
<main class="page">
	 	<section class="shopping-cart ">
	 		<div class="container">
		        <div class="block-heading">
		          <h2>Shopping Cart</h2>
		          
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
	 				<div class="row">
	 					<div class="col-md-12 col-lg-8">
	 						<div class="items">
				 				<div class="product card-body">
				 					<div class="row">
					 					<div class="col-md-3">
					 						<img class="img-fluid mx-auto d-block image m-4" src="{{ asset('storage/'.$service->img_path.'') }}">
					 					</div>
					 					<div class="col-md-8">
					 						<div class="info">
						 						<div class="row">
							 						<div class="col-md-5 product-name">
							 							<div class="product-name">
								 							<a href="#">{{ $service->title }}</a>
								 							<div class="product-info">
									 							<div>P.method: <span class="value">{{ $service->p_method }}</span></div>
									 							<div>Duration: <span class="value">{{ $service->duration }} day</span></div>
									 							<div>Purshases: <span class="value">{{ $service->purchases_number }}</span></div>
									 							<div>Remaining: <span class="value">{{ $service->remaining }}</span></div>
									 						</div>
									 					</div>
							 						</div>
							 						<div class="col-md-4 quantity">
							 							<label for="quantity">Quantity:</label>
							 							<select id="quantity" class="form-control" name="quantity" onchange="the_quantity();">
							 								{{ $i = 0 }}
							 								@while($i != $service->remaining)
							 								{{ $i++ }}
							 								<option value="{{ $i }}">{{ $i }}</option>
							 								@endwhile
							 							</select>
							 						</div>
							 						<div class="col-md-3 price">
							 							<span><a id="price">{{ $service->price }}</a> {{ $service->currency }}</span>
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
			 					<h3>Summary</h3>
			 					<div class="summary-item"><span class="text">Account balance:</span><span class="price">{{ $balance }} {{ $service->currency }}</span></div>
			 					<div class="summary-item"><span class="text" id="price">Price ({{ $service->p_method }})</span><span class="price">- {{ $service->price }} {{ $service->currency }}</span></div>
			 					<div class="summary-item"><span class="text">Fees</span><span class="price">- 0 {{ $service->currency }}</span></div>
			 					<div class="summary-item"><span class="text">New balance</span><span class="price" id="new_bal">{{ $new_bal }}</span></div>
			 					<input type="hidden" name="service_id" value="{{ $service->id }}">
			 					<button type="submit" id="button" class="btn btn-primary btn-lg btn-block" {{ $status }}>Checkout</button>
								<a id="msj" class="text-danger text-center">{{$msj}}</a>

				 			</div>
			 			</div>
		 			</div> 
		 			</form>
		 		</div>
	 		</div>
		</section>
	</main>



@endsection