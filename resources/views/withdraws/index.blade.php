@extends('layouts.app')


@section('content')





<div class="container">
	<div class="row">

		<div class="col">
			<button class="btn btn-link float-right mb-2" onclick="window.location.assign('{{ url('withdraw/create') }}')">New withdraw</button>
			<table class="table table-striped table-hover" id="withdraws">
			  <thead class="thead-dark">
			    <tr>
				  <th scope="col">ID</th>
			      <th scope="col">P.method</th>
			      <th scope="col">Amount</th>
				  <th scope="col">Created at</th>
				  <th scope="col">Last activity</th>
				  <th scope="col">Queue</th>
			      <th scope="col">Status</th>
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

					@elseif($withdraw->the_status == "canceled")
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
				      <td><h5><span class="badge badge-{{$badge_type}}">{{ $withdraw->the_status }}</span></h5></td>
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
    	"order": [[ 0, "desc" ]]
    });
} );
</script>

@endsection