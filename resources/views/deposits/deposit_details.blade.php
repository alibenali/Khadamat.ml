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

<div class="container-fluid">
	<div class="row">

		<div class="col">
			<div class="card text-center">
				<h4 class="m-4 p-2">Deposit request <a class="font-weight-bold">({{ $deposit->amount .' '.  $deposit->p_method }} {{ $deposit->currency }})</a></h4>


				<div class="border border-left-0 border-right-0">
					<small class="float-left p-0 m-2">{{ $deposit->created_at }}</small>
					<p class="p-5">
						<big>Thanks for your deposit. We're looking into your request (<a href="{{ url('deposit/'.$deposit->id.'') }}">#{{ $deposit->id }}</a>)</big>
						<br>
						Generally all deposits are veryfied in the order they are created. Occasionally, due to some requests requiring more research than others and also due to excessive demand, a reply may take longer than one business day. Please accept our apologies in advance for any reply that exceeds this time frame, but be assured we are working hard to get back to you as quickly as possible to provide a considerate response.

						Thanks for your patience
					</p>
				</div>


				@if($deposit->the_status == "Accepted")
					<div class="border border-left-0 border-right-0">
						<small class="float-left p-0 m-2">{{ $deposit->updated_at }}</small>
						<p class="p-5">
							<big>Great! Your deposit request has been accepted.</big><br>
							Your profile {{  $deposit->p_method }} {{ $deposit->currency }} balance has been updated, <a href="{{ url('home') }}">visit profile</a><br>
							<a class="font-weight-bold">+ {{ $deposit->amount }} {{  $deposit->p_method }} {{ $deposit->currency }}</a>
						</p>
					</div>
				@elseif($deposit->the_status == "Refused")
					<div class="border border-left-0 border-right-0">
						<small class="float-left p-0 m-2">{{ $deposit->updated_at }}</small>
						<p class="p-5">
							<big>Your deposit request has been refused.</big><br>
							If you think this is a mistake, contact us as soon as possible.<br>
							<br>
							<a class="btn-link" href="{{ url('https://m.me/machrou3.2019') }}">Facebook</a> | 
							<a href = "mailto:support@machrou3.com?subject = Deposit request has been refused per mistake">
								support@machrou3.com</a> | 
							<a href="tel:+213553301252">+213553301252</a>
						</p>	
					</div>
				@elseif($deposit->the_status == "Open")
					<div class="float-center">

						@if(Auth::user()->is_admin and Auth::id() != $deposit->user_id)

						<!-- Button trigger modal -->
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#accept_modal">
						  Accept
						</button>

						<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#refuse_modal">
						  Refuse
						</button>
						
						@include('layouts.modals.admin_deposit_options')

						@else
						<button class="btn btn-link text-muted" onclick="confirm_click('Do you want really cancel the deposit ?', '{{ action('DepositController@cancel', ['id' => $deposit->id]) }}')">Cancel deposit</button> |
						<button class="btn btn-link text-muted" onclick="confirm_click('Please make sur that you have just 2 urgent verification at month', '{{ action('DepositController@urgent_verification', ['id' => $deposit->id]) }}')">urgent_verification</button>
						@endif

					</div>
				@elseif($deposit->the_status == "Canceled")
					<div class="border border-left-0 border-right-0">
						<small class="float-left p-0 m-2">{{ $deposit->updated_at }}</small>
						<p class="p-5">
							<big>You canceled the deposit</big>
						</p>
					</div>
				@endif
			</div>
		</div>


		<div class="col-xl-3 col-lg-4">
			<div class="card">
				<div class="card-body">
					<h3 class="pb-5"><span class="float-right badge badge-{{ $badge_type }}">{{ $deposit->the_status }}</span></h3>
					
					<table>
					<tr>
						<td><a class="font-weight-bold">P.method</a></td>
						<td>: {{  $deposit->p_method }} {{ $deposit->currency }}</td>
					</tr>

					<tr>
						<td><a class="font-weight-bold">Amount</a></td>
						<td>: {{ $deposit->amount }}</td>
					</tr>

					<tr>
						<td><a class="font-weight-bold">Send date</a></td>
						<td>: {{ $deposit->send_date }}</td>
					</tr>

					<tr>
						<td><a class="font-weight-bold">Created at</a></td>
						<td>: {{ $deposit->created_at }}</td>
					</tr>

					<tr>
						<td><a class="font-weight-bold">Last activity</a></td>
						<td>: {{ $deposit->updated_at }}</td>
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