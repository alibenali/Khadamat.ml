@extends('layouts.app')


@section('content')





<div class="container" {{ $rtl }}>
	<div class="row">

		<div class="col">

			<button class="btn btn-light border mb-2 mt-5 pt-0 pb-0 float-right" onclick="window.location.assign('{{ url('deposit/create') }}')">{{ __('deposit.newDeposit') }}</button>

			<table class="table table-striped table-hover table-responsive w-100 d-block d-md-table" id="deposits">
			  <thead>
			    <tr>
				  <th scope="col">{{ __('deposit.id') }}</th>
			      <th scope="col">{{ __('deposit.paymentMethod') }}</th>
			      <th scope="col">{{ __('deposit.currency') }}</th>
			      <th scope="col">{{ __('deposit.amount') }}</th>
			      <th scope="col">{{ __('deposit.sentDate') }}</th>
				  <th scope="col">{{ __('deposit.createdAt') }}</th>
				  <th scope="col">{{ __('deposit.lastActivity') }}</th>
				  <th scope="col">{{ __('deposit.qeue') }}</th>
			      <th scope="col">{{ __('deposit.status') }}</th>
			    </tr>
			  </thead>

		  	  <tbody>
				@foreach ($deposits as $deposit)

					@if($deposit->the_status == "Open")
						@php ($badge_type = "primary")

					@elseif($deposit->the_status == "Accepted")
						@php ($badge_type = "success")

					@elseif($deposit->the_status == "Refused")
						@php ($badge_type = "danger")

					@elseif($deposit->the_status == "Canceled")
						@php ($badge_type = "warning")
					@endif
				 
				 
				    <tr onclick="window.location.assign('{{ url('deposit/'.$deposit->id.'') }}')" style="cursor: pointer;">
				      <th scope="row"><a href="{{ url('deposit/'.$deposit->id.'') }}">{{ $deposit->id }}</a></th>
				      <td>{{ $deposit->p_method }}</td>
				      <td>{{ $deposit->currency }}</td>
				      <td>{{ $deposit->amount }}</td>
					  <td>{{ $deposit->send_date }}</td>
				      <td>{{ $deposit->created_at }}</td>
				      <td>{{ $deposit->updated_at }}</td>
				      @if($deposit->the_queue < 9999999 )
				      <td>{{ $deposit->the_queue }}</td>
				      @else
				      <td><a class="muted"><small>{{ __('deposit.expired') }}</small></a></td>
					  @endif
				      <td class="text-center"><span class="badge badge-{{$badge_type}}">{{  __('deposit.'.$deposit->the_status) }}</span></td>
				    </tr>	
				

			    @endforeach

		  	  </tbody>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready( function () {
    $('#deposits').DataTable({
    	"order": [[ 0, "desc" ]],
    	"searching": false,
    	"bLengthChange": false,
    });
} );


</script>

@endsection