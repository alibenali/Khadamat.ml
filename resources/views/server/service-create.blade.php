@extends('layouts.app')

@section('content')



<script src="//cdn.ckeditor.com/4.12.1/full/ckeditor.js"></script>
<div class="container">
	


		<form action="{{ url('server/service') }}" method="POST" enctype="multipart/form-data">
			
			{{ csrf_field() }}

			<div class="form-group">
				<label for="title">Title</label>
				<input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
			</div>

			<div class="form-row">
				<div class="form-group col">
						<label for="category">Categories</label>
						<select class="form-control dynamicCategory" id="category" name="category" data-dependent="sub_category" required>
								<option>select category</option>
							@foreach( $categories as $category)
								<option value="{{ $category->slug_name }}">{{ $category->name }}</option>
							@endforeach
						</select>
				</div>

				<div class="form-group col">
						<label for="sub_category">Sub Categories</label>
						<select class="form-control" id="sub_category" name="sub_category"  required>
								<option>select sub-category</option>
							@foreach( $sub_categories as $sub_category)
								<option value="{{ $sub_category->slug_name }}">{{ $sub_category->name }}</option>
							@endforeach
						</select>
				</div>
			</div>

			<div class="form-row">
				<div class="form-group col">
					<label for="price">Price</label>
					<input type="number" class="form-control" id="price" name="price" value=" {{ old('price') }}">
				</div>
				<div class="form-group col">
					<label for="duration">Duration</label>
					<select class="form-control" id="duration" name="duration">
						<option value="1">30 - 60 Minutes</option>
						<option value="2">01 - 06 Hours</option>
						<option value="3">06 - 12 Hours</option>
						<option value="4">12 - 24 Hours</option>
						<option value="5">01 - 03 Days</option>
						<option value="6">03 - 06 Days</option>
						<option value="7">06 - 12 Days</option>
						<option value="8">12 - 24 Days</option>
						<option value="9">24 - 48 Days</option>
						<option value="10">01 - 03 Months</option>
						<option value="11">03 - 06 Months</option>
						<option value="12">06 - 12 Months</option>
					</select>
				</div>

				<div class="form-group col">
					<label for="remaining">Quantity</label>
					<input type="number" class="form-control" id="remaining" name="remaining" value="{{ old('remaining') }}">
				</div>
				
			</div>

			<div class="form-row">
				<div class="form-group col">
					<label for="p_method">{{ __('deposit.paymentMethod') }}</label>
					<select class="form-control dynamic" id="p_method" name="p_method" data-dependent="currency" required>
							<option>{{ __('deposit.select') }} {{ __('deposit.paymentMethod') }}</option>
						@foreach( $payment_methods as $payment_method)
							<option value="{{ $payment_method->name }}">{{ $payment_method->name }}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group col">
					<label for="currency">{{ __('deposit.currency') }}</label>
					<select class="form-control" id="currency" name="currency" required>
						<option>{{ __('deposit.select') }} {{ __('deposit.currency') }}</option>
						@foreach( $currencies as $currency)
							<option value="{{ $currency->name }}">{{ $currency->name }}</option>
						@endforeach
					</select>
				</div>
				
				
			</div>

			<div class="form-group">
				<label for="desc">Description</label>
				<textarea name="desc" id="desc">{{ old('desc') }}</textarea>
                <script>
                        CKEDITOR.replace( 'desc' );
                </script>
			</div>

			<input type="file" name="image">
			<button class="btn btn-dark float-right">Create</button>
		</form>
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
  }
 });

 $('#p_method').change(function(){
  $('#currency').val('');
 });




 $('.dynamicCategory').change(function(){
  if($(this).val() != '')
  {
   var select = $(this).attr("id");
   var value = $(this).val();
   var dependent = $(this).data('dependent');
   var _token = $('input[name="_token"]').val();
   $.ajax({
    url:"{{ route('service.fetch') }}",
    method:"POST",
    data:{select:select, value:value, _token:_token, dependent:dependent},
    success:function(result)
    {
     $('#'+dependent).html(result);
    }
   })
  }
 });

 $('#category').change(function(){
  $('#sub_category').val('');
 });


});
</script>
@endsection()