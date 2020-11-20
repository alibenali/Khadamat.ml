@extends('layouts.app')


@section('content')

<script src="//cdn.ckeditor.com/4.12.1/full/ckeditor.js"></script>

<div class="container">
<form method="POST" action="{{ url('server/service/'. $service->id) }}" enctype="multipart/form-data">
	<input type="hidden" name="_method" value="PUT">
	@csrf
	<div class="pt-1 pl-3 pr-3">
		<label for="title"><h5 class="font-weight-bold">Service Title</h5></label>
		<input name="title" id="title" class="form-control" value="{{ $service->title }}"  />
		<hr>
	</div>

	<div class="pt-1 pl-3 pr-3">
		<label for="category"><h5 class="font-weight-bold">Service category</h5></label>
		<select class="form-control dynamicCategory" id="category" name="category" data-dependent="sub_category" required>
								<option selected="" value="{{ $service->category }}">{{ $service->category }}</option>
							@foreach( $categories as $category)
								<option value="{{ $category->slug_name }}">{{ $category->name }}</option>
							@endforeach
						</select>
		<hr>
	</div>

	<div class="pt-1 pl-3 pr-3">
		<label for="sub_category"><h5 class="font-weight-bold">Service subcategory</h5></label>
		<select class="form-control" id="sub_category" name="sub_category"  required>
								<option selected="" value="{{ $service->sub_category }}">{{ $service->sub_category }}</option>
							@foreach( $sub_categories as $sub_category)
								<option value="{{ $sub_category->slug_name }}">{{ $sub_category->name }}</option>
							@endforeach
						</select>
		<hr>
	</div>



	<div class="pt-1 pl-3 pr-3">
		<label for="price"><h5 class="font-weight-bold">Service price</h5></label>
		<input name="price" id="price" class="form-control" value="{{ $service->price }}"  />
		<hr>
	</div>



	<div class="pt-1 pl-3 pr-3">
		<label for="p_method"><h5 class="font-weight-bold">Service p_method</h5></label>
		<select class="form-control dynamic" id="p_method" name="p_method" data-dependent="currency" required>
								<option selected="" value="{{ $service->p_method }}">{{ $service->p_method }}</option>
						@foreach( $payment_methods as $payment_method)
							<option value="{{ $payment_method->name }}">{{ $payment_method->name }}</option>
						@endforeach
					</select>
		<hr>
	</div>

	<div class="pt-1 pl-3 pr-3">
		<label for="currency"><h5 class="font-weight-bold">Service currency</h5></label>
		<select class="form-control" id="currency" name="currency" required>
								<option selected="" value="{{ $service->currency }}">{{ $service->currency }}</option>
						@foreach( $currencies as $currency)
							<option value="{{ $currency->name }}">{{ $currency->name }}</option>
						@endforeach
					</select>
		<hr>
	</div>

	<div class="pt-1 pl-3 pr-3">
		<label for="duration"><h5 class="font-weight-bold">Service duration</h5></label>
		<select class="form-control" id="duration" name="duration">
						<option selected="" value="{{ $service->duration }}">{{ $service->duration }}</option>
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
		<hr>
	</div>



	<div class="pt-1 pl-3 pr-3">
		<label for="remaining"><h5 class="font-weight-bold">Service remaining</h5></label>
		<input name="remaining" id="remaining" class="form-control" value="{{ $service->remaining }}"  />
		<hr>
	</div>



	<div class="pt-1 pl-3 pr-3">
		<label for="status"><h5 class="font-weight-bold">Service status</h5></label>
		<select class="form-control" name="status" id="status">
			<option value="{{ $service->the_status }}" selected="">{{ $service->the_status }}</option>
			<option value="open">open</option>
			<option value="closed">closed</option>
		</select>
		<hr>
	</div>



	<div class="pt-1 pl-3 pr-3">
		<label for="Description"><h5 class="font-weight-bold">Service Description</h5></label>
		<textarea name="desc" id="desc">{{ $service->description }}</textarea>
                <script>
                        CKEDITOR.replace( 'desc' );
                </script>
		<hr>
	</div>

	<input type="file" name="image">

	<button class="btn btn-primary float-right" type="submit">Save</button>
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

@endsection