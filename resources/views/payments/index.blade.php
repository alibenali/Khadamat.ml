@extends('layouts.app')


@section('content')





<div class="container" {{ $rtl }}>
	<div class="row">

		<div class="col">

			<table class="table mt-4 table-striped table-hover table-responsive w-100 d-block d-md-table" id="payments">
			  <thead>
			    <tr>
			      <th scope="col">{{ __('payment.id') }}</th>
				  <th scope="col">{{ __('payment.service') }}</th>
			      <th scope="col">{{ __('payment.quantity') }}</th>
			      <th scope="col">{{ __('payment.paymentMethod') }}</th>
			      <th scope="col">{{ __('payment.currency') }}</th>
				  <th scope="col">{{ __('payment.price') }}</th>
				  <th scope="col">{{ __('payment.fees') }}</th>
				  <th scope="col">{{ __('payment.total') }}</th>
			      <th scope="col">{{ __('payment.status') }}</th>
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
				 
				 
				    <tr onclick="window.location.assign('{{ url('payment/'.$payment->id.'') }}')"  style="cursor: pointer;">
				      <td>{{ $payment->id }}</td>
				      <td><a href="{{ url('service/'.$payment->service->id) }}"><img src="{{ asset('storage/'.$payment->service->img_path.'') }}" style="width: 30px;height: 30px;border-radius: 50%;"></a></td>
				      <td>{{ $payment->quantity }}</td>
					  <td>{{ $payment->payment_method }}</td>
					  <td>{{ $payment->currency }}</td>
				      <td>{{ $payment->price }}</td>
				      <td>{{ $payment->fees }}</td>
				      <td>{{ $payment->total }}</td>
				      <td><span class="badge badge-{{$badge_type}}">{{ __('payment.'.$payment->the_status) }}</span></td>
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