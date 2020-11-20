@extends('layouts.app')

@section('content')


        @if($conversation->the_status == "open")
            @php ($badge_type = "primary")
        @elseif($conversation->the_status == "pending")
            @php ($badge_type = "primary")
        @elseif($conversation->the_status == "accepted")
            @php ($badge_type = "success")
        @elseif($conversation->the_status == "refused")
            @php ($badge_type = "danger")
        @elseif($conversation->the_status == "cancelled")
            @php ($badge_type = "warning")
        @else
            @php ($badge_type = "warning")
        @endif

<link rel="stylesheet" type="text/css" href="{{ asset('css/conversation.css') }}">

<script type="text/javascript">
	$(function(){
		'use strict';

		// Adjust Slider Height

		var WinH = $(window).height(),
		navH	 = $('.navbar').innerHeight();

		$('.chat-container').height(WinH - (navH + 150));
        $('#mydiv').height((WinH - (navH + 24)) - 230 );

	});
</script>

<div class="container chat-container">
    <div class="row h-100">
        <div class="col d-flex p-0 mh-100 mr-lg-5">
            <div class="card" style="min-width: 100%">
                <div class="card-header bg-lightblue text-white py-1 px-2 pt-3" style="flex: 1 1">
                    <div class="d-flex flex-row justify-content-start">
                        <div class="col">
                            <div class="my-0">
                                <a href="{{ url('service/'.$service->id) }}">
                                    <img class="img-fluid border d-inline" src="{{ asset('storage/'.$service->img_path.'') }}" style="width: 55px;height: 55px;border-radius: 50%;">
                                </a>
                                <h6 class="d-none d-md-inline ml-3"><b><a href="{{ url('service/'.$service->id) }}" class="color-darkblue">{{ substr($service->title, 0,60) }}..</a></b></h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-lightgrey d-flex flex-column p-0" style="flex: 9 1">
                    <div class="container-fluid message-scroll p-4" id="mydiv" style="height: 500px;">

                        @foreach($messages as $message)
                            @if($message->user_id == Auth::user()->id)
                            <div class="row justify-content-end">
                                <div class="card message-card bg-lightblue m-1" data-toggle="tooltip" data-placement="left" title="{{$message->created_at->format('Y-m-d, H:i')}}">
                                    <div class="card-body p-2">
                                        <span class="mx-2">{{$message->content}}</span>
                                        <span class="float-right mx-1"><small><i class="fas fa-check fa-fw" style="color:green"></i></small></span>
                                    </div>
                                </div>
                            </div>
                            @elseif($message->the_type == "offer")

                                <small>{{ $message->created_at->format('Y-m-d, H:i') }}</small>
										<br>
                                <div class="row justify-content-center">
                                	<div class="col-10">
                                        <div class="card">
                                            <div class="card-header">
                                            	<div class="row">
	                                            	<div class="col">
	                                            		{{ $offer[($message->content - 1)]->title }}
	                                            	</div>
	                                            	<div class="col-lg-3 col-xs-12" {{ $rtl }}>
	                                            		{{ __('conversation.price') }} : {{ $offer[($message->content - 1)]->price }} {{ $offer[($message->content - 1)]->currency }} {{ $offer[($message->content - 1)]->p_method }}
	                                            	</div>
                                            	</div>
                                            </div>
                                            <div class="card-body">
                                                <p>{{ $offer[($message->content - 1)]->details }}</p>
                                                <hr>
                                                <div class="float-right">
                                                @can('accept', $offer[($message->content - 1)])
												<button type="button" class="btn btn-success" data-toggle="modal" data-target="#{{ $offer[($message->content - 1)]->id }}">{{ __('conversation.acceptOffer') }}
                                                </button>
                                                @include("layouts.modals.accept_offer")
                                                @else
                                                    {{$offer[($message->content - 1)]->the_status}}
                                                @endcan
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($message->the_type == "rating")
                            	@if($rating == 'noRating')

                                <form method="POST" action="{{ action('RatingController@rateService') }}">
                                	@csrf
                                    <div class="card">
                                        <div class="card-body">
                                            <div align="center" style="color:white;">
                                                <div class="border" style="width: 200px;">
                                                <i class="fa fa-star fa-2x" data-index="0" style="text-shadow: 0 0 1px #000; padding: 5px;"></i>
                                                <i class="fa fa-star fa-2x" data-index="1" style="text-shadow: 0 0 1px #000;"></i>
                                                <i class="fa fa-star fa-2x" data-index="2" style="text-shadow: 0 0 1px #000;"></i>
                                                <i class="fa fa-star fa-2x" data-index="3" style="text-shadow: 0 0 1px #000;"></i>
                                                <i class="fa fa-star fa-2x" data-index="4" style="text-shadow: 0 0 1px #000;"></i>
                                                </div>
                                            </div>
                                            <br><br>
                                            <label for="comment">{{ __('conversation.ratingComment') }}</label>
                                            <textarea id="comment" class="form-control" rows="3" maxlength="1800" style="resize:none; overflow: hidden;" name="comment" required=""></textarea> 
                                            <input type="hidden" name="num_stars" id="stars_num"  required="">
                                            <input type="hidden" name="service_id" value="{{ $service->id }}">
                                            <input type="hidden" name="conversation_id" value="{{ $payment->conversation_id }}">

                                            <button class="btn btn-primary mt-2 float-right">{{ __('conversation.sendReview') }}</button>
                                        </div>
                                    </div> 
                                </form>
                                @else


                                    <div class="card">
                                        <div class="card-body">
                                            <div align="center" style="color:white;">
                                                <div class="border" style="width: 200px;">
                                                <i class="fa fa-star fa-2x" data-index="0" style="text-shadow: 0 0 1px #000; padding: 5px;"></i>
                                                <i class="fa fa-star fa-2x" data-index="1" style="text-shadow: 0 0 1px #000;"></i>
                                                <i class="fa fa-star fa-2x" data-index="2" style="text-shadow: 0 0 1px #000;"></i>
                                                <i class="fa fa-star fa-2x" data-index="3" style="text-shadow: 0 0 1px #000;"></i>
                                                <i class="fa fa-star fa-2x" data-index="4" style="text-shadow: 0 0 1px #000;"></i>
                                                </div>
                                            </div>
                                            <br><br>
                                            <p class="border p-2"> {{ $rating->comment }} </p> 
                                            <input type="hidden" name="num_stars" id="stars_num" value="0">
                                            <input type="hidden" name="service_id" value="{{ $service->id }}">

                                        </div>
                                    </div> 

                            	
                            	@endif

                                <br><hr>

                            @elseif($message->user_id == 0)
                                <div class="alert alert-primary m-5">{{$message->created_at->format('Y-m-d, H:i')}} {{ __('conversation.'.$message->content) }}</div>
                            @else
                            <div class="row">
                                <div class="card message-card m-1 red-tooltip" data-toggle="tooltip" data-placement="left" title="{{$message->created_at->format('Y-m-d, H:i')}}">
                                    <div class="card-body p-2">
                                        <span class="mx-2">{{ $message->content }}</span>

                                    </div>
                                </div>
                            </div>                            
                            @endif

                            @if($loop->last)
                                @PHP ($last_msj = $message->id)
                            @endif

                        @endforeach  
                    </div>
                    <a class="text-muted text-right p-3 d-none" id="sendingseen"></a>

                    <form method="POST" action="{{ action('MessageController@store') }}" id="my_form">
                        @csrf
                    <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                    <div class="input-group">
                        <textarea id="textarea" class="form-control border-0" placeholder="{{ __('conversation.inputMessage') }}" rows="2" maxlength="900" style="resize:none; overflow: hidden;" name="message"></textarea> 
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

        <div class="col-12 col-lg-4 p-0">
            <br>
<br>
<br>
<br>

            <div class="card">
                <div class="card-body">
                    <h3 class="pb-5"><span class="float-right badge badge-{{ $badge_type }}">{{ __('conversation.'.$conversation->the_status) }}</span></h3>
                    
                    <table class="w-100"  {{ $rtl }}>  
                    
                    <tr>
                        <td><a class="font-weight-bold">{{ __('conversation.servicePrice') }}</a> :</td>
                        <td> {{ $payment->price }} {{ $payment->currency }} {{ $payment->payment_method }}</td>
                    </tr>

                    <tr>
                        <td><a class="font-weight-bold">{{ __('conversation.serviceFees') }}</a> :</td>
                        <td> {{ $payment->fees }} {{ $payment->currency }} {{ $payment->payment_method }}</td>
                    </tr>

                    <tr>
                        <td><a class="font-weight-bold">{{ __('conversation.quantity') }}</a> :</td>
                        <td> {{ $payment->quantity }}</td>
                    </tr>
                   @foreach($offer as $indexKey => $offer)
                        @if($offer->the_status == 'paid')

                        @if($indexKey = 1)
                        <tr><td class="pt-4"><a class="font-weight-bold text-primary">{{ __('conversation.paidOffers') }}</a></td></tr>
                        @endif
                            <tr>
                                <td><a class="font-weight-bold" title="{{ $offer->title }}">#{{$indexKey+1}} </a> : </td>
                                <td> {{ $offer->price }} {{ $offer->currency }} {{ $offer->p_method }}</td>
                            </tr>
                        @endif
                    @endforeach
                    </table>
					<br><br>

						<div {{ $rtl }}><a class="font-weight-bold text-primary">{{ __('conversation.total') }}: <a class="text-dark">{{ $payment->fees + ($payment->price * $payment->quantity) + $offers_price }} {{ $payment->currency }} {{ $payment->payment_method }}</a></a>

                        @can('cancel', $payment)
                        <!-- Button cancel payment -->
                        <a class="float-right" data-toggle="modal" data-target="#cancel_payment">
                         <u> {{ __('conversation.cancelPaymant') }} </u>
                        </a>
                        </div>
                        @include('layouts.modals.user_payment_options')
                        @endcan
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
    url:"{{ route('manage.conversation.fetch') }}",
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

        if(result.type == "offer" || result.type == "controller" || result.type == "rating"){
            $('#mydiv').html(result.html);
            rating();
        }else{
            append_message(result);
        }
        intialize();
        setTimeout(get_data, 5000);
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
     $("#sendingseen").text("sending message...");
     $("#sendingseen").addClass("d-inline");

    var _token = $('input[name="_token"]').val();
    var conversation_id = {{ $conversation->id }};


$.ajax({
    url:"{{ route('message.ajax') }}",
    method:"POST",
    data:{_token:_token, conversation_id:conversation_id, message:message},
    success:function(result)
    {
        append_my_message(message);
        $("#sendingseen").text("");
        $("#sendingseen").addClass("d-none");
        intialize();
    }

   })

}
$("textarea").val('');
return false;
}
});

get_data();
});


    function append_my_message(message){
        var d = new Date();
        var time = d.getHours() + ":" + d.getMinutes();

        var $sorting_message = "<div class='row justify-content-end' ><div class='card message-card bg-lightblue m-1' data-toggle='tooltip' data-placement='left' title='" + time + "'><div class='card-body p-2'><span class='mx-2'>" + message + "</span><span class='float-right mx-1'><small><i class='fas fa-check fa-fw' style='color:green'></i></small></span></div></div></div>";

            $("#mydiv").append($sorting_message);
    }

    function append_message(result){


        var $coming_message = "<div class='row'><div class='card message-card m-1 red-tooltip' data-toggle='tooltip' data-placement='left' title='" + result.created_at + "'><div class='card-body p-2'><span class='mx-2'>" + result.content + "</span></div></div></div>";

        $("#mydiv").append($coming_message);
            

    }

</script>

<!-- Rating stars  -->
<script>

        function rating(){
        var ratedIndex = -1;
        
        resetStarColors();


        function setStars(max) {
            for (var i=0; i <= max; i++){
                $('.fa-star:eq('+i+')').css('color', '#ffc100');
            }
            
        }

        function resetStarColors() {
            //$('.fa-star').css('color', '#fffdd1');
            $('.fa-star').css('color', 'white');
        }
        	var n = 'no';
            if ({{ @$rating['num_stars'] }} != 'no') {
                setStars(parseInt({{ @$rating['num_stars'] }} - 1));
            }else{

            $('.fa-star').on('click', function () {
               ratedIndex = parseInt($(this).data('index'));
               $('#stars_num').val(ratedIndex+1);
            });

            $('.fa-star').mouseover(function () {
                resetStarColors();
                var currentIndex = parseInt($(this).data('index'));
                setStars(currentIndex);
            });

            $('.fa-star').mouseleave(function () {
                resetStarColors();

                if (ratedIndex != -1)
                    setStars(ratedIndex);
            });
            }
        }
        rating();
    
    </script>

@endsection