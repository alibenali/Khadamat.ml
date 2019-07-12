@extends('layouts.app')


@section('content')





<div class="container">
	<div class="row">

		<div class="col">
			<button class="btn btn-link float-right mb-2" onclick="window.location.assign('{{ url('deposit/create') }}')">New deposit</button>
			<table class="table table-striped table-hover" id="deposits">
			  <thead class="thead-dark">
			    <tr>
				  <th scope="col">ID</th>
			      <th scope="col">Payment method</th>
			      <th scope="col">Currency</th>
			      <th scope="col">Amount</th>
			      <th scope="col">Sending date</th>
				  <th scope="col">Created at</th>
				  <th scope="col">Last activity</th>
				  <th scope="col">Queue</th>
			      <th scope="col">Status</th>
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
				 
				 
				    <tr onclick="window.location.assign('{{ url('deposit/'.$deposit->id.'') }}')">
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
				      <td><a class="muted"><small>Expired</small></a></td>
					  @endif
				      <td class="text-center"><h4><span class="badge badge-{{$badge_type}}">{{ $deposit->the_status }}</span></h4></td>
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
    	"order": [[ 0, "desc" ]]
    });
} );
</script>

@endsection