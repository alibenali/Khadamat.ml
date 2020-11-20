@extends('layouts.app')


@section('content')





<div class="container" {{ $rtl }}>
	<div class="row">

		<div class="col">
			
			<table class="table mt-4 table-striped table-hover table-responsive w-100 d-block d-md-table" id="payments">
			  <thead>
			    <tr>
			      <th>Id</th>
				  <th>Service id</th>
				  <th>User id</th>
				  <th>Quantity</th>
				  <th>P.method</th>
				  <th>Price</th>
				  <th>The status</th>
				  <th>Actions</th>
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
				     <td>{{ $payment->id }}</td>
				     <td>{{ $payment->service_id }}</td>
				     <td>{{ $payment->user_id }}</td>
				     <td>{{ $payment->quantity }}</td>
				     <td>{{ $payment->payment_method }}</td>
				     <td>{{ $payment->price.' '.$payment->currency }}</td>
				     <td>{{ $payment->the_status }}</td>


				     <td>

					      	<a class="btn btn-success" onclick="window.location.assign('{{ url('server/conversation/'.$payment->conversation_id.'') }}')">View</a>
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