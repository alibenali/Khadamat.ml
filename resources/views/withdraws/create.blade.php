@extends('layouts.app')



@section('content')

<div class="container">
	

		<div class="col-lg-5 mx-auto mt-3">
			<form action="{{ url('withdraw') }}" method="post">
				{{ csrf_field() }}

				<div class="form-group">
					<label for="p_method">{{ __('withdraw.paymentMethod') }}</label>
					<select class="form-control dynamic" id="p_method" name="p_method" data-dependent="currency" required>
							<option>{{ __('withdraw.select') }} {{ __('withdraw.paymentMethod') }}</option>
						@foreach( $payment_methods as $payment_method)
							<option value="{{ $payment_method->name }}">{{ $payment_method->name }}</option>
						@endforeach
					</select>
				</div>


				<div class="form-group">
					<label for="currency">{{ __('withdraw.currency') }}</label>
					<select class="form-control" id="currency" name="currency" required>
						<option>{{ __('withdraw.select') }} {{ __('withdraw.currency') }}</option>
						@foreach( $currencies as $currency)
							<option value="{{ $currency->name }}">{{ $currency->name }}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group" id="paymentInfoDiv">
					<label for="paymentInfo"><a id="changePaymentInfo">{{ __('withdraw.paymentInfo') }}</label>
					<input type="text" class="form-control" id="paymentInfo" name="p_info" placeholder="">
				</div>

				<div class="form-group">
					<label for="amount">{{ __('withdraw.amount') }}</label>
					<input type="number" class="form-control" id="amount" name="amount" placeholder="1000" required>
				</div>

				<button class="btn btn-dark float-right">{{ __('withdraw.sendWithdraw') }}</button>
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
   })}

   if(value == 'paypal'){
		document.getElementById('changePaymentInfo').innerHTML ='Email Paypal';
		document.getElementById('paymentInfo').type = 'email';
		document.getElementById('paymentInfo').placeholder ='';
	}else if(value == 'paysera'){
		document.getElementById('changePaymentInfo').innerHTML ='Email Paysera';
		document.getElementById('paymentInfo').type = 'email';
		document.getElementById('paymentInfo').placeholder ='';

	}else if(value == 'ccp'){
		document.getElementById('changePaymentInfo').innerHTML ='RIP';
		document.getElementById('paymentInfo').type = 'number';
		document.getElementById('paymentInfo').placeholder ='007 99999 0025557009 16';

	}

 });

 $('#p_method').change(function(){
  $('#currency').val('');
 });



});
</script>

@endsection