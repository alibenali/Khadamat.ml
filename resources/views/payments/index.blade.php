@extends('layouts.app')


@section('content')





<div class="container">
	<div class="row">

		<div class="col">

			<table class="table table-striped table-hover" id="payments">
			  <thead class="thead-dark">
			    <tr>
				  <th scope="col">ID</th>
				  <th scope="col">User</th>
			      <th scope="col">Service</th>
			      <th scope="col">Quantity</th>
			      <th scope="col">Payment method</th>
				  <th scope="col">Price</th>
				  <th scope="col">Fees</th>
				  <th scope="col">Total</th>
			      <th scope="col">Status</th>
			    </tr>
			  </thead>

		  	  <tbody>
				@foreach ($payments as $payment)

					@if($payment->the_status == "open")
						@php ($badge_type = "primary")

					@elseif($payment->the_status == "accepted")
						@php ($badge_type = "success")

					@elseif($payment->the_status == "refused")
						@php ($badge_type = "danger")

					@elseif($payment->the_status == "canceled")
						@php ($badge_type = "warning")
					@endif
				 
				 
				    <tr onclick="window.location.assign('{{ url('payment/'.$payment->id.'') }}')">
				      <th scope="row"><a href="{{ url('payment/'.$payment->id.'') }}">{{ $payment->id }}</a></th>
				      <td>{{ $payment->user->name }}</td>
				      <td>{{ $payment->service_id }}</td>
				      <td>{{ $payment->quantity }}</td>
					  <td>{{ $payment->payment_method }}</td>
				      <td>{{ $payment->price }}</td>
				      <td>{{ $payment->fees }}</td>
				      <td>{{ $payment->price + $payment->fees }}</td>
				      <td><h5><span class="badge badge-{{$badge_type}}">{{ $payment->the_status }}</span></h5></td>
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
    	"order": [[ 5, "desc" ]]
    });
} );
</script>

@endsection