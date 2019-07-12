@extends('layouts.return-admin')




@section('page_header')
	<div class="container-fluid">
		<h1 class="page-title">
			<i class="icon voyager-news"></i> Conversation
		</h1>
	</div>
@stop


@section('content')


        @if($conversation->the_status == "open")
            @php ($badge_type = "primary")
        @elseif($conversation->the_status == "accepted")
            @php ($badge_type = "success")
        @elseif($conversation->the_status == "refused")
            @php ($badge_type = "danger")
        @elseif($conversation->the_status == "canceled")
            @php ($badge_type = "warning")
        @endif

        

<link rel="stylesheet" type="text/css" href="{{ asset('css/conversation.css') }}">

<script type="text/javascript">
	$(function(){
		'use strict';

		// Adjust Slider Height

		var WinH = $(window).height(),
		navH	 = $('.navbar').innerHeight();

		$('.chat-container').height(WinH - 95);

	});
</script>

<div class="container-fluid chat-container">
    <div class="row h-100">
        <div class="col d-flex p-0 mh-100">
            <div class="card" style="min-width: 100%">
                <div class="card-header bg-darkblue text-white py-1 px-2" style="flex: 1 1">
                    <div class="d-flex flex-row justify-content-start">
                        <div class="col">
                            <div class="my-0">
                                <b>{{ $service->title }}</b>
                            </div>
                            <div class="my-0">
                                <small>{{ $service->price }} {{ $service->currency }} {{ $service->p_method }}</small>
                            </div>
                        </div>
                        @can('create_offer', $payment)
                        <!-- Button trigger modal -->
                            <button type="button" class="btn btn-outline-light" data-toggle="modal" data-target="#offer">
                              Create offer
                            </button>
                            @include('layouts.modals.admin_create_offer')
                        @endcan
                    </div>
                </div>
                <div class="card-body bg-lightgrey d-flex flex-column p-0" style="flex: 9 1">
                    <div class="container-fluid message-scroll" id="mydiv" style="flex: 1 1">

                        @foreach($messages as $message)
                            @if($message->the_type == "offer") 
                                <small>{{ $message->created_at->format('Y-m-d, H:i') }}</small><br>
                                <div class="row justify-content-center">
                                    <div class="col-10">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="row">
                                                    <div class="col">
                                                        {{ $offer[($message->content - 1)]->title }}
                                                    </div>
                                                    <div class="col-lg-3 col-xs-12">
                                                        Price: {{ $offer[($message->content - 1)]->price }} {{ $offer[($message->content - 1)]->currency }} {{ $offer[($message->content - 1)]->p_method }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <p>{{ $offer[($message->content - 1)]->details }}</p>
                                                <hr>
                                                <div class="float-right">
                                                        <button class="btn btn-primary" disabled="">{{ $offer[($message->content - 1)]->the_status }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($message->user_id == Auth::user()->id)
                            <div class="row justify-content-end">
                                <div class="card message-card bg-lightblue m-1" data-toggle="tooltip" data-placement="left" title="{{$message->created_at->format('Y-m-d, H:i')}}">
                                    <div class="card-body p-2">
                                        <span class="mx-2">{{$message->content}}</span>
                                        <span class="float-right mx-1"><small><i class="fas fa-check fa-fw" style="color:green"></i></small></span>
                                    </div>
                                </div>
                            </div>
                                
                            @else
                            <div class="row">
                                <div class="card message-card m-1 red-tooltip" data-toggle="tooltip" data-placement="left" title="{{$message->created_at->format('Y-m-d, H:i')}}">
                                    <div class="card-body p-2">
                                        <span class="mx-2">{{$message->content}}</span>

                                    </div>
                                </div>
                            </div>                            
                            @endif

                            @if($loop->last)
                                @PHP ($last_msj = $message->id)
                            @endif

                        @endforeach    
                    </div>
                    <form method="POST" action="{{ action('MessageController@store') }}" id="my_form">
                        @csrf
                    <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                    <div class="input-group">
                        <textarea id="textarea" class="form-control border-0" placeholder="Input message..." rows="2" maxlength="900" style="resize:none; overflow: hidden;" name="message"></textarea> 
                        <span class="input-group-addon bg-white">
                            <button class="btn mt-2 border-0 text-primary bg-white hover-color-darkblue" type="submit">
                                <i class="fab fa-telegram-plane fa-2x"></i>
                            </button>
                        </span>
                    </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="col-xs-12 col-md-4 col-lg-3 p-0">
            <div class="card">
                <div class="card-body">
                    <h3 class="pb-5"><span class="float-right badge badge-{{ $badge_type }}">{{ $conversation->the_status }}</span></h3>
                    
                    <table>  
                    
                    <tr>
                        <td><a class="font-weight-bold">Service Price</a></td>
                        <td>: {{ $payment->price }} {{ $service->currency }} {{ $payment->payment_method }}</td>
                    </tr>

                    <tr>
                        <td><a class="font-weight-bold">Service Fees</a></td>
                        <td>: {{ $payment->fees }} {{ $service->currency }} {{ $payment->payment_method }}</td>
                    </tr>

                    <tr>
                        <td><a class="font-weight-bold">Quantity</a></td>
                        <td>: {{ $payment->quantity }}</td>
                    </tr>
                    
                    @foreach($offer as $indexKey => $offer)
                        @if($offer->the_status == 'paid')

                        @if($indexKey = 1)
                        <tr><td class="pt-4"><a class="font-weight-bold text-primary">Paid offers</a></td></tr>
                        @endif
                            <tr>
                                <td><a class="font-weight-bold" title="{{ $offer->title }}">#{{$indexKey+1}} </a></td>
                                <td>: {{ $offer->price }} {{ $offer->currency }} {{ $offer->p_method }}</td>
                            </tr>
                        @endif
                    @endforeach
                    </table>
					<br><br>

						<a class="font-weight-bold text-primary">Total: <a class="text-dark">{{ $payment->fees + ($payment->price * $payment->quantity) }} {{ $service->currency }} {{ $payment->payment_method }}</a></a>

                    <br><br>
                    <img class="img-fluid border" src="{{ asset('storage/'.$service->img_path.'') }}">

                    <br><br>

					<!-- Button trigger modal -->
					@can('accept', $payment)
					@if($payment->the_status == "open")
					<button type="button" class="btn btn-success" data-toggle="modal" data-target="#accept_modal">
					  Accept
					</button>
					@endif
					@endcan
					@can('refuse', $payment)
					@if($payment->the_status == "open")
					<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#refuse_modal">
					  Refuse
					</button>
					@endif
					@endcan
					@include('layouts.modals.admin_payment_options')
                </div>
            </div>
        </div>

    </div>
    <!-- row -->
</div>
<!-- container -->





<script>
    
$(document).ready(function(){
    
    var _token = $('input[name="_token"]').val();
    var conversation_id = {{ $conversation->id }};
    var last_msj_id = {{ $last_msj }};


function intialize(){
    // js of toolip over
         $("div").tooltip();

         // chat scroll down 
        var objDiv = document.getElementById("mydiv");
        objDiv.scrollTop = objDiv.scrollHeight;
}
intialize();

 function get_data(){
   $.ajax({
    url:"{{ route('conversation.fetch') }}",
    method:"POST",
    data:{_token:_token, conversation_id:conversation_id, last_msj_id:last_msj_id},
    success:function(result)
    {
     

    if(result.id === undefined){
        // no messages yet
        setTimeout(get_data, 5000);
    }else{
        // let show this new messsage
        var result = result;
        append_message(result);
        intialize();
        setTimeout(get_data, 3000);
     }

    }

   })

 }

 $('#textarea').keydown(function() {
var message = $("#textarea").val();
if (event.keyCode == 13) {
if (message == "") {
alert("Enter Some in input field, ok !!");
} else {

    var _token = $('input[name="_token"]').val();
    var conversation_id = {{ $conversation->id }};


$.ajax({
    url:"{{ route('message.ajax') }}",
    method:"POST",
    data:{_token:_token, conversation_id:conversation_id, message:message},
    success:function(result)
    {
        get_data();
    }

   })

}
$("textarea").val('');
return false;
}
});

get_data();
});



    function append_message(result){

        var $sorting_message = "<div class='row justify-content-end' ><div class='card message-card bg-lightblue m-1' data-toggle='tooltip' data-placement='left' title=''><div class='card-body p-2'><span class='mx-2'>" + result.content + "</span><span class='float-right mx-1'><small><i class='fas fa-check fa-fw' style='color:green'></i></small></span></div></div></div>";

        var $coming_message = "<div class='row'><div class='card message-card m-1 red-tooltip' data-toggle='tooltip' data-placement='left' title='" + result.created_at + "'><div class='card-body p-2'><span class='mx-2'>" + result.content + "</span></div></div></div>";



        if(result.type == "offer"){

            var $offer = "<small>" + result.created_at + "</small><br><div class='row justify-content-center'><div class='col-10'><div class='card'><div class='card-header'><div class='row'><div class='col'>" + result.title + "</div><div class='col-lg-3 col-xs-12'>Price: " + result.price + " " + result.currency + " " + result.p_method + "</div></div></div><div class='card-body'><p>" + result.details + "</p><hr><div class='float-right'><button class='btn btn-primary' disabled=''>" + result.the_status + "</button></div></div></div></div></div>";

            $("#mydiv").append($offer);
        }else{
            if(result.user_id == {{ $user_id }}){
             $("#mydiv").append($sorting_message);
            }else{
             $("#mydiv").append($coming_message);
            }
        }
        

    }

</script>



@endsection