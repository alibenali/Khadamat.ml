@extends('layouts.app')


@section('content')





<div class="container" {{ $rtl }}>
	<div class="row">

		<div class="col">
			
			<table class="table mt-4 table-striped table-hover table-responsive w-100 d-block d-md-table" id="payments">
			  <thead>
			    <tr>
			      <th>Conversation Id</th>
				  <th>Service Id</th>
				  <th>Buyer Id</th>
				  <th>Total</th>
				  <th>The status</th>
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
					@else
						@php ($badge_type = "warning")
					@endif
				 
				 
				    <tr>
				     <td><a href="{{ url('server/conversation/'.$payment->conversation_id.'') }}">{{ $payment->id }}</a></td>
				     <td><a href="{{ url('service/'.$payment->service_id.'') }}">{{ $payment->service_id }}</a></td>
				     <td><a href="{{ url('profile/'.$payment->user_id.'') }}"> {{ $payment->user_id }}</a></td>
				     <td>{{ $payment->total.' '.$payment->currency.' - '.$payment->payment_method }}</td>
				     <td>{{ $payment->server_status }}</td>

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