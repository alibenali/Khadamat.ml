@extends('layouts.app')


@section('content')


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

<div class="container-fluid" {{ $rtl }}>
	<div class="row">

		<div class="col">
			<div class="card text-center">
				<h4 class="m-4 p-2"> {{ __('withdraw.withdrawRequest') }} <a class="font-weight-bold"> | {{ $withdraw->amount .' '.  $withdraw->p_method }} {{ $withdraw->currency }}</a></h4>


				<div class="border border-left-0 border-right-0">
					<small class="float-left p-0 m-2">{{ $withdraw->created_at }}</small>
					<p class="p-5">
						<big> {{ __('withdraw.thanksForwithdraw') }} </big>
						<br>
						{{ __('withdraw.withdrawSteps') }}
					</p>
				</div>


				@if($withdraw->the_status == "accepted")
					<div class="border border-left-0 border-right-0">
						<small class="float-left p-0 m-2">{{ $withdraw->updated_at }}</small>
						<p class="p-5">
							<big>{{ __('withdraw.withdrawAccepted') }}</big><br>
							Your profile {{  $withdraw->p_method }} {{ $withdraw->currency }} balance has been updated, <a href="{{ url('home') }}">visit profile</a><br>
							<a class="font-weight-bold">+ {{ $withdraw->amount }} {{  $withdraw->p_method }} {{ $withdraw->currency }}</a>
						</p>
					</div>
				@elseif($withdraw->the_status == "refused")
					<div class="border border-left-0 border-right-0">
						<small class="float-left p-0 m-2">{{ $withdraw->updated_at }}</small>
						<p class="p-5">
							<big>{{ __('withdraw.withdrawRefused') }}</big><br>
							{{ __('withdraw.refusedMistake') }}
							<br>
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
						<button class="btn btn-link text-muted" onclick="confirm_click('Do you want really cancel the withdraw ?', '{{ action('WithdrawController@cancel', ['id' => $withdraw->id]) }}')">{{ __('withdraw.cancelWithdraw') }}</button> |
						<button class="btn btn-link text-muted">{{ __('withdraw.urgentVerification') }}</button>
						@endif

					</div>
				@elseif($withdraw->the_status == "canceled")
					<div class="border border-left-0 border-right-0">
						<small class="float-left p-0 m-2">{{ $withdraw->updated_at }}</small>
						<p class="p-5">
							<big>{{ __('withdraw.youCancelledWithdraw') }}
							</big>
						</p>
					</div>
				@endif
			</div>
		</div>


		<div class="col-xl-4 col-lg-4">
			<div class="card">
				<div class="card-body">
					<h3 class="pb-5"><span class="float-right badge badge-{{ $badge_type }}">{{ __('withdraw.'.$withdraw->the_status) }}</span></h3>
					
					<table class="w-100">
					<tr>
						<td><a class="font-weight-bold">{{ __('withdraw.paymentMethod') }}</a> : </td>
						<td> {{ $withdraw->p_method }}</td>
					</tr>

					<tr>
						<td><a class="font-weight-bold">{{ __('withdraw.amount') }}</a> : </td>
						<td> {{ $withdraw->amount }}</td>
					</tr>

					<tr>
						<td><a class="font-weight-bold">{{ __('withdraw.createdAt') }}</a> : </td>
						<td> {{ $withdraw->created_at }}</td>
					</tr>

					<tr>
						<td><a class="font-weight-bold">{{ __('withdraw.lastActivity') }}</a> : </td>
						<td> {{ $withdraw->updated_at }}</td>
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