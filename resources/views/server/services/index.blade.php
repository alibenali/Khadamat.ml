@extends('layouts.app')


@section('content')





<div class="container" {{ $rtl }}>
	<div class="row">

		<div class="col">
			<button class="btn btn-light border mb-2 mt-5 pt-0 pb-0 float-right" onclick="window.location.assign('{{ url('server/service/create') }}')">{{ __('service.newService') }}</button>
			<table class="table mt-4 table-striped table-hover table-responsive w-100 d-block d-md-table" id="payments">
			  <thead>
			    <tr>
				  <th scope="col">{{ __('payment.service') }}</th>
			      <th scope="col">{{ __('payment.quantity') }}</th>
			      <th scope="col">{{ __('payment.paymentMethod') }}</th>
				  <th scope="col">{{ __('payment.price') }}</th>
				  <th scope="col">{{ __('payment.fees') }}</th>
				  <th scope="col">{{ __('payment.total') }}</th>
			      <th scope="col">{{ __('payment.status') }}</th>
			      <th scope="col"></th>
			    </tr>
			  </thead>

		  	  <tbody>
				@foreach ($services as $service)

					@if($service->the_status == "open")
						@php ($badge_type = "primary")

					@elseif($service->the_status == "accepted")
						@php ($badge_type = "success")

					@elseif($service->the_status == "refused")
						@php ($badge_type = "danger")

					@elseif($service->the_status == "canceled")
						@php ($badge_type = "warning")
					@else
						@php ($badge_type = "warning")
					@endif
				 
				 
				    <tr>
				      <td><a href="{{ url('service/'.$service->id) }}" target="_blank"><img src="{{ asset('storage/'.$service->img_path.'') }}" style="width: 30px;height: 30px;border-radius: 50%;"></a></td>
				      <td>{{ $service->remaining }}</td>
					  <td>{{ $service->p_method }}</td>
				      <td>{{ $service->price.' '.$service->currency }}</td>
				      <td>{{ $service->fees }}</td>
				      <td>{{ $service->price + $service->fees }}</td>
				      <td><span class="badge badge-{{$badge_type}}">{{ __('payment.'.$service->the_status) }}</span></td>
				      <td>
				      	<form method="POST" action="{{ url('server/service/'.$service->id) }}">
				      		@csrf
							{{ method_field('DELETE') }}

					      	<a class="btn btn-success" onclick="window.location.assign('{{ url('server/service/'.$service->id.'') }}')">View</a>
					      	<a class="btn btn-primary" onclick="window.location.assign('{{ url('server/service/'.$service->id.'/edit') }}')">Edit</a>
					      	<button type="submit" class="btn btn-danger">Delete</button>
				        </form>
				      </td>
				    </tr>	
				

			    @endforeach

		  	  </tbody>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready( function () {
    $('#payments').DataTable({
    	"order": [[ 0, "desc" ]],
    	"searching": false,
    	"bLengthChange": false,
    });
} );
</script>

@endsection