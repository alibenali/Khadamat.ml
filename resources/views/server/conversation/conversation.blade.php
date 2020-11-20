@extends('layouts.return-admin')



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

        var WinH = $(window).height();

        $('.chat-container').height(WinH - 110);
        $('#mydiv').height((WinH - 300) );

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
                    <div class="container-fluid message-scroll p-4" id="mydiv" style="height: 500px;">

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
                                
                            @elseif($message->user_id == 0)
                                <div class="alert alert-primary m-5">{{$message->created_at->format('Y-m-d, H:i')}} {{$message->content}}</div>
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
                    <a class="text-muted text-right p-3 d-none" id="sendingseen"></a>
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


        <div class="col-xs-12 col-lg-4 p-0 mt-5">
            <div class="card">
                <div class="card-body">
                    <h3 class="pb-5"><span class="float-right badge badge-{{ $badge_type }}">{{ $conversation->the_status }}</span></h3>
                    
                    <table>  
                    
                    <tr>
                        <td><a class="font-weight-bold">Service Price</a></td>
                        <td>: {{ $payment->price }} {{ $payment->currency }} {{ $payment->payment_method }}</td>
                    </tr>

                    <tr>
                        <td><a class="font-weight-bold">Service Fees</a></td>
                        <td>: {{ $payment->fees }} {{ $payment->currency }} {{ $payment->payment_method }}</td>
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

						<a class="font-weight-bold text-primary">Total: <a class="text-dark">{{ $payment->fees + $offers_price + ($payment->price * $payment->quantity) }} {{ $payment->currency }} {{ $payment->payment_method }}</a></a>

                </div>
            </div>

                <div class="m-5">
                <!-- Button trigger modal -->
                    @can('pending', $payment)
                    <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#pending_modal">
                      Mark as pending
                    </button>
                    @endcan

                    @can('accept', $payment)
                    <button type="button" class="btn btn-success mt-3" data-toggle="modal" data-target="#accept_modal">
                     Mark as completed
                    </button>
                    @endcan
                    @can('refuse', $payment)
                    <button type="button" class="btn btn-danger mt-3" data-toggle="modal" data-target="#refuse_modal">
                      Refuse
                    </button>
                    @endcan

                    @include('layouts.modals.admin_payment_options')
                </div>
                
                    @can('refund', $payment)
                    <button type="button" class="btn mt-3" data-toggle="modal" data-target="#refund_modal">
                     Refund
                    </button>
                    @endcan
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
    url:"{{ route('server.conversation.fetch') }}",
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


        if(result.type == "offer"){

            var $offer = "<small>" + result.created_at + "</small><br><div class='row justify-content-center'><div class='col-10'><div class='card'><div class='card-header'><div class='row'><div class='col'>" + result.title + "</div><div class='col-lg-3 col-xs-12'>Price: " + result.price + " " + result.currency + " " + result.p_method + "</div></div></div><div class='card-body'><p>" + result.details + "</p><hr><div class='float-right'><button class='btn btn-primary' disabled=''>" + result.the_status + "</button></div></div></div></div></div>";

            $("#mydiv").append($offer);
        }else{
          $("#mydiv").append($coming_message);

        }
        

    }

</script>



@endsection