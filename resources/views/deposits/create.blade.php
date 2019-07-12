@extends('layouts.app')



@section('content')

<div class="container">


		<div class="col-lg-5">
			<a class="btn btn-link m-0 p-0" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Payment info
			</a>
			<div class="collapse" id="collapseExample">
				<div class="card card-body">
					<ul class="list-group list-group-flush">
					  <li class="list-group-item"><a class="font-weight-bold mr-3">CCP</a> 42 0025557009 Ali BENALI</li>
					  <li class="list-group-item"><a class="font-weight-bold mr-3">Paypal</a> cocktillo@gmail.com</li>
					  <li class="list-group-item"><a class="font-weight-bold mr-3">Paysera</a> cocktillo@gmail.com</li>
					</ul>
				</div>
			</div>
		</div>
	

		<div class="col-lg-5 mx-auto mt-3">
			<form action="{{ url('deposit') }}" method="post" enctype="multipart/form-data">
				{{ csrf_field() }}

				<div class="form-group">
					<label for="p_method">Payment Method</label>
					<select class="form-control dynamic" id="p_method" name="p_method" data-dependent="currency" required>
							<option>Select Payment Method</option>
						@foreach( $payment_methods as $payment_method)
							<option value="{{ $payment_method->name }}">{{ $payment_method->name }}</option>
						@endforeach
					</select>
				</div>


				<div class="form-group">
					<label for="currency">Currency</label>
					<select class="form-control" id="currency" name="currency" required>
						<option>Select Currency</option>
						@foreach( $currencies as $currency)
							<option value="{{ $currency->name }}">{{ $currency->name }}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group">
					<label for="amount">Amount</label>
					<input type="number" class="form-control" id="amount" name="amount" placeholder="1000" required>
				</div>

				<div class="form-group">
					<label for="send_date">Sending date</label>
					<input type="date" class="form-control" id="send_date" name="send_date" required>
				</div>

				<div class="form-group" id="pic" style="height: 0;visibility: hidden;opacity: 0;transition: opacity 1200ms ease 0s, visibility 1200ms ease 0s;">
					<label for="img">The receipt (recu)</label>
					<input type="file" class="form-control p-1" id="img" name="img">
				</div>

				<button class="btn btn-dark float-right">Send deposit</button>
			</form>
		</div>


	
</div>



<script>
$(document).ready(function(){

 $('.dynamic').change(function(){
  if($(this).val() != '')
  {
   var select = $(this).attr("id");
   var value = $(this).val();
   var dependent = $(this).data('dependent');
   var _token = $('input[name="_token"]').val();
   $.ajax({
    url:"{{ route('deposit.fetch') }}",
    method:"POST",
    data:{select:select, value:value, _token:_token, dependent:dependent},
    success:function(result)
    {
     $('#'+dependent).html(result);
    }

   })



   if(value == 'ccp'){
		document.getElementById('pic').style.visibility='initial';
		document.getElementById('pic').style.height='60px';
		document.getElementById('pic').style.opacity='3';
	}else{
		document.getElementById('pic').style.opacity='0';
		document.getElementById('pic').style.height='0px';
		document.getElementById('pic').style.visibility='hidden';

	}


  }
 });

 $('#p_method').change(function(){
  $('#currency').val('');
 });



});
</script>

@endsection