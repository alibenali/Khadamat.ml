@extends('layouts.app')


@section('content')





<div class="container" {{ $rtl }}>
	<div class="row">

		<div class="col">
			<button class="btn btn-light border mb-2 mt-5 pt-0 pb-0 float-right"onclick="window.location.assign('{{ url('withdraw/create') }}')">{{ __('withdraw.newWithdraw') }}</button>
			<table class="table table-striped table-hover table-responsive w-100 d-block d-md-table" id="withdraws">
			  <thead class="">
			    <tr>
				  <th scope="col">{{ __('withdraw.id') }}</th>
			      <th scope="col">{{ __('withdraw.paymentMethod') }}</th>
			      <th scope="col">{{ __('withdraw.amount') }}</th>
				  <th scope="col">{{ __('withdraw.createdAt') }}</th>
				  <th scope="col">{{ __('withdraw.lastActivity') }}</th>
				  <th scope="col">{{ __('withdraw.qeue') }}</th>
			      <th scope="col">{{ __('withdraw.status') }}</th>
			    </tr>
			  </thead>

		  	  <tbody>
				@foreach ($withdraws as $withdraw)

					@if($withdraw->the_status == "open")
						@php ($badge_type = "primary")

					@elseif($withdraw->the_status == "accepted")
						@php ($badge_type = "success")

					@elseif($withdraw->the_status == "refused")
						@php ($badge_type = "danger")

					@elseif($withdraw->the_status == "cancelled")
						@php ($badge_type = "warning")
					@elseif($withdraw->the_status == "pending")
						@php ($badge_type = "warning")
					@endif
				 
				 
				    <tr onclick="window.location.assign('{{ url('withdraw/'.$withdraw->id.'') }}')">
				      <th scope="row"><a href="{{ url('withdraw/'.$withdraw->id.'') }}">{{ $withdraw->id }}</a></th>
				      <td>{{ $withdraw->p_method }}</td>
				      <td>{{ $withdraw->amount }}</td>
				      <td>{{ $withdraw->created_at }}</td>
				      <td>{{ $withdraw->updated_at }}</td>
				      @if($withdraw->the_queue > 5000)
				      <td>Expired</td>
				      @else
				      <td>{{ $withdraw->the_queue }}</td>
				      @endif
				      <td><h5><span class="badge badge-{{$badge_type}}">{{ __('withdraw.'.$withdraw->the_status) }}</span></h5></td>
				    </tr>	
				

			    @endforeach

		  	  </tbody>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready( function () {
    $('#withdraws').DataTable({
    	"order": [[ 0, "desc" ]],
    	"searching": false,
    	"bLengthChange": false,
    });
} );
</script>

@endsection