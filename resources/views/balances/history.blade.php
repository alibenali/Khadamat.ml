@extends('layouts.app')


@section('content')





<div class="container" {{ $rtl }}>
	<div class="row">

		<div class="col">
			<table class="table table-striped table-hover table-responsive w-100 d-block d-md-table" id="BalanceHistory">
			  <thead>
			    <tr>
			      <th scope="col">{{ __('balance.id') }}</th>
				  <th scope="col">{{ __('balance.date') }}</th>
			      <th scope="col">{{ __('balance.purpose') }}</th>
			      <th scope="col">{{ __('balance.paymentMethod') }}</th>
			      <th scope="col">{{ __('balance.oldBalance') }}</th>
			      <th scope="col">{{ __('balance.balanceAmount') }}</th>
			      <th scope="col">{{ __('balance.newBalance') }}</th>
			    </tr>
			  </thead>

		  	  <tbody>
				@foreach ($BalanceHistory as $BalanceHistory)

				 
				    <tr>
				      <th scope="row">{{ $BalanceHistory->id }}</td>
				      <td>{{ $BalanceHistory->created_at }}</th>
				      <td><a href="{{ url($BalanceHistory->url) }}">{{ $BalanceHistory->purpose }}</a></td>
				      <td>{{ $BalanceHistory->p_method }}</td>
				      <td>{{ $BalanceHistory->old }}</td>
				      <td>{{ $BalanceHistory->amount }}</td>
				      <td>{{ $BalanceHistory->new }}</td>

				    </tr>	
				

			    @endforeach

		  	  </tbody>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready( function () {
    $('#BalanceHistory').DataTable({
    	"order": [[ 0, "desc" ]],
    });
} );


</script>

@endsection