@extends('layouts/app')

@section('content')

<div class="container">
	
	@if ($errors->any())
	    <div class="alert alert-danger">
	        <ul> 
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
	@endif

		<form action="{{ url('service') }}" method="POST" enctype="multipart/form-data">
			
			{{ csrf_field() }}

			<div class="form-group">
				<label for="title">Title</label>
				<input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
			</div>

			<div class="form-row">
				<div class="form-group col">
					<label for="price">Price</label>
					<input type="number" class="form-control" id="price" name="price" value=" {{ old('price') }}">
				</div>

				<div class="form-group col">
					<label for="p_method">P. method</label>
					<select class="form-control" id="p_method" name="p_method">
						<option value="CCP">CCP</option>
						<option>Paysera</option>
						<option>Paypal</option>
					</select>
				</div>
			</div>

			<div class="form-row">

				<div class="form-group col">
					<label for="currency">Currency</label>
					<select class="form-control" id="currency" name="currency">
						<option value="DA">DA</option>
						<option>USD</option>
						<option>EURO</option>
					</select>
				</div>
				
				<div class="form-group col">
					<label for="duration">Duration</label>
					<input type="number" class="form-control" id="duration" name="duration" value="{{ old('duration') }}">
				</div>

				<div class="form-group col">
					<label for="remaining">Quantity</label>
					<input type="number" class="form-control" id="remaining" name="remaining" value="{{ old('remaining') }}">
				</div>
			</div>

			<div class="form-group">
				<label for="desc">Description</label>
				<textarea type="text" class="form-control" id="desc" name="desc">{{ old('desc') }}</textarea> 
			</div>

			<input type="file" name="image">
			<button class="btn btn-dark float-right">Create</button>
		</form>
</div>
@endsection()