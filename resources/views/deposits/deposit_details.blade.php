@extends('layouts.app')


@section('content')


@if($deposit->the_status == "Open")
	@php ($badge_type = "primary")
@elseif($deposit->the_status == "Accepted")
	@php ($badge_type = "success")
@elseif($deposit->the_status == "Refused")
	@php ($badge_type = "danger")
@elseif($deposit->the_status == "Canceled")
	@php ($badge_type = "warning")
@endif

<div class="container-fluid" {{ $rtl }}>
	<div class="row">

		<div class="col">
			<div class="card text-center">
				<h4 class="m-4 p-2"> {{ __('deposit.depositRequest') }} <a class="font-weight-bold"> | {{ $deposit->amount .' '.  $deposit->p_method }} {{ $deposit->currency }}</a></h4>


				<div class="border border-left-0 border-right-0">
					<small class="float-left p-0 m-2">{{ $deposit->created_at }}</small>
					<p class="p-5">
						<big> {{ __('deposit.thanksForDeposit') }} </big>
						<br>
						{{ __('deposit.depositSteps') }}
					</p>
				</div>


				@if($deposit->the_status == "Accepted")
					<div class="border border-left-0 border-right-0">
						<small class="float-left p-0 m-2">{{ $deposit->updated_at }}</small>
						<p class="p-5">
							<big>{{ __('deposit.depositAccepted') }}</big><br>
							Your profile {{  $deposit->p_method }} {{ $deposit->currency }} balance has been updated, <a href="{{ url('home') }}">visit profile</a><br>
							<a class="font-weight-bold">+ {{ $deposit->amount }} {{  $deposit->p_method }} {{ $deposit->currency }}</a>
						</p>
					</div>
				@elseif($deposit->the_status == "Refused")
					<div class="border border-left-0 border-right-0">
						<small class="float-left p-0 m-2">{{ $deposit->updated_at }}</small>
						<p class="p-5">
							<big>{{ __('deposit.depositRefused') }}</big><br>
							{{ __('deposit.refusedMistake') }}
							<br>
							<br>
							<a class="btn-link" href="{{ url('https://m.me/machrou3.2019') }}">Facebook</a> | 
							<a href = "mailto:support@machrou3.com?subject = Deposit request has been refused per mistake">
								support@machrou3.com</a> | 
							<a href="tel:+213553301252">+213553301252</a>
						</p>	
					</div>
				@elseif($deposit->the_status == "Open")
					<div class="float-center">

						<button class="btn btn-link text-muted" onclick="confirm_click('Do you want really cancel the deposit ?', '{{ action('DepositController@cancel', ['id' => $deposit->id]) }}')">
						{{ __('deposit.cancelDeposit') }}</button> |
						<button class="btn btn-link text-muted" onclick="confirm_click('Please make sur that you have just 2 urgent verification at month', '{{ action('DepositController@urgent_verification', ['id' => $deposit->id]) }}')">{{ __('deposit.urgentVerification') }}</button>

					</div>
				@elseif($deposit->the_status == "Canceled")
					<div class="border border-left-0 border-right-0">
						<small class="float-left p-0 m-2">{{ $deposit->updated_at }}</small>
						<p class="p-5">
							<big>{{ __('deposit.youCancelledDeposit') }}
							</big>
						</p>
					</div>
				@endif
			</div>
		</div>


		<div class="col-xl-4 col-lg-4">
			<div class="card">
				<div class="card-body">
					<h3 class="pb-5"><span class="float-right badge badge-{{ $badge_type }}">{{ __('deposit.'.$deposit->the_status) }}</span></h3>
					
					<table class="w-100">
					<tr>
						<td><a class="font-weight-bold">{{ __('deposit.paymentMethod') }}</a> : </td>
						<td>{{  $deposit->p_method }} {{ $deposit->currency }}</td>
					</tr>

					<tr>
						<td><a class="font-weight-bold">{{ __('deposit.amount') }}</a> : </td>
						<td>{{ $deposit->amount }}</td>
					</tr>

					<tr>
						<td><a class="font-weight-bold">{{ __('deposit.sentDate') }}</a> : </td>
						<td>{{ $deposit->send_date }}</td>
					</tr>

					<tr>
						<td><a class="font-weight-bold">{{ __('deposit.createdAt') }}</a> : </td>
						<td>{{ $deposit->created_at }}</td>
					</tr>

					<tr>
						<td><a class="font-weight-bold">{{ __('deposit.lastActivity') }}</a> : </td>
						<td>{{ $deposit->updated_at }}</td>
					</tr>

					</table>

					<hr>
					@if(!empty($deposit->img_path))
					<label for="img" class="font-weight-bold">Prove image:</label>
					<img onmouseover="this.style.cursor='pointer'" id="img" data-toggle="modal" data-target="#exampleModal" class="img-fluid border" src="{{ asset('storage/'.$deposit->img_path.'') }}">
					@endif
				</div>
			</div>
		</div>
	</div>
</div>




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="float-right m-2" aria-hidden="true">&times;</span>
        </button>
		<div class="pt-0 modal-body">
  		<img onclick="window.open('{{ asset('storage/'.$deposit->img_path.'') }}')" class="img-fluid border" src="{{ asset('storage/'.$deposit->img_path.'') }}">
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