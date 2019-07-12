@extends('layouts.app')



@section('content')

<div class="container">
	

		<div class="col-lg-5 mx-auto mt-3">
			<form action="{{ url('withdraw') }}" method="post">
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

				<button class="btn btn-dark float-right">Send Withdraw</button>
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
 });

 $('#p_method').change(function(){
  $('#currency').val('');
 });



});
</script>

@endsection