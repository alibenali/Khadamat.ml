@extends('layouts.app')


@section('content')


@if($withdraw->the_status == "open")
	@php ($badge_type = "primary")
@elseif($withdraw->the_status == "accepted")
	@php ($badge_type = "success")
@elseif($withdraw->the_status == "refused")
	@php ($badge_type = "danger")
@elseif($withdraw->the_status == "canceled")
	@php ($badge_type = "warning")
@endif

<div class="container-fluid">
	<div class="row">

		<div class="col">
			<div class="card text-center">
				<h4 class="m-4 p-2">withdraw request <a class="font-weight-bold">({{ $withdraw->amount .' '. $withdraw->p_method }})</a></h4>


				<div class="border border-left-0 border-right-0">
					<small class="float-left p-0 m-2">{{ $withdraw->created_at }}</small>
					<p class="p-5">
						<big>Thanks for your withdraw. We're looking into your request (<a href="{{ url('withdraw/'.$withdraw->id.'') }}">#{{ $withdraw->id }}</a>)</big>
						<br>
						Generally all withdraws are veryfied in the order they are created. Occasionally, due to some requests requiring more research than others and also due to excessive demand, a reply may take longer than one business day. Please accept our apologies in advance for any reply that exceeds this time frame, but be assured we are working hard to get back to you as quickly as possible to provide a considerate response.

						Thanks for your patience
					</p>
				</div>


				@if($withdraw->the_status == "accepted")
					<div class="border border-left-0 border-right-0">
						<small class="float-left p-0 m-2">{{ $withdraw->updated_at }}</small>
						<p class="p-5">
							<big>Great! Your withdraw request has been accepted.</big><br>
							Your profile {{ $withdraw->p_method }} balance has been updated, <a href="{{ url('home') }}">visit profile</a><br>
							<a class="font-weight-bold">+ {{ $withdraw->amount }} {{ $withdraw->p_method }}</a>
						</p>
					</div>
				@elseif($withdraw->the_status == "refused")
					<div class="border border-left-0 border-right-0">
						<small class="float-left p-0 m-2">{{ $withdraw->updated_at }}</small>
						<p class="p-5">
							<big>Your withdraw request has been refused.</big><br>
							If you think this is a mistake, contact us as soon as possible.<br>
							<br>
							<a class="btn-link" href="{{ url('https://m.me/machrou3.2019') }}">Facebook</a> | 
							<a href = "mailto:support@machrou3.com?subject = withdraw request has been refused per mistake">
								support@machrou3.com</a> | 
							<a href="tel:+213553301252">+213553301252</a>
						</p>	
					</div>
				@elseif($withdraw->the_status == "open")
					<div class="float-center">

						@if(Auth::user()->is_admin and Auth::id() != $withdraw->user_id)

						<!-- Button trigger modal -->
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#accept_modal">
						  Accept
						</button>

						<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#refuse_modal">
						  Refuse
						</button>
						
						@include('layouts.modals.admin_withdraw_options')

						@else
						<button class="btn btn-link text-muted" onclick="confirm_click('Do you want really cancel the withdraw ?', '{{ action('WithdrawController@cancel', ['id' => $withdraw->id]) }}')">Cancel withdraw</button> |
						<button class="btn btn-link text-muted">Urgent verification</button>
						@endif

					</div>
				@elseif($withdraw->the_status == "canceled")
					<div class="border border-left-0 border-right-0">
						<small class="float-left p-0 m-2">{{ $withdraw->updated_at }}</small>
						<p class="p-5">
							<big>You canceled the withdraw</big>
						</p>
					</div>
				@endif
			</div>
		</div>


		<div class="col-xl-3 col-lg-4">
			<div class="card">
				<div class="card-body">
					<h3 class="pb-5"><span class="float-right badge badge-{{ $badge_type }}">{{ $withdraw->the_status }}</span></h3>
					
					<table>
					<tr>
						<td><a class="font-weight-bold">P.method</a></td>
						<td>: {{ $withdraw->p_method }}</td>
					</tr>

					<tr>
						<td><a class="font-weight-bold">Amount</a></td>
						<td>: {{ $withdraw->amount }}</td>
					</tr>

					<tr>
						<td><a class="font-weight-bold">Created at</a></td>
						<td>: {{ $withdraw->created_at }}</td>
					</tr>

					<tr>
						<td><a class="font-weight-bold">Last activity</a></td>
						<td>: {{ $withdraw->updated_at }}</td>
					</tr>

					</table>

					<hr>

					
				</div>
			</div>
		</div>
	</div>
</div>




<script>
function confirm_click(message, url) {
  var r = confirm(message);
  if (r == true) {
    window.location.assign(url);
  }
}
</script>

@endsection