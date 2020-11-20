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