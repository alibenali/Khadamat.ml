@extends('layouts/app')

@section('content')


<style type="text/css">
span.badge.pull-left {
    margin-right: 10px;
}



.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;width: 50%;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-baqh{text-align:center;vertical-align:top}
.tg .tg-nrix{text-align:center;vertical-align:middle}

</style>

<div class="container">


	<div class="row">	
		<div class="col" style="min-width: 250px;">

			<div class="card mt-2">

			<h4 class="font-weight-bold pt-4 pl-4 pr-4 mb-3">{{ $service->title }}</h4>
			<hr align="center" width="92%" class="mx-auto m-0">

			  <ol class="breadcrumb bg-white pl-4 pr-4 mb-4">
			    <li class="breadcrumb-item"><a href="{{ url('services/'.$service->category) }}">{{ $service->category }}</a></li>
			    <li class="breadcrumb-item active"><a href="{{ url('services/'.$service->category.'/'.$service->sub_category) }}">{{ $service->sub_category }}</a></li>
			  </ol>

			<img src="{{asset('storage/'.$service->img_path.'')}}" class="img-fluid" alt="Responsive image" />
			</div>
		</div>

		<div class="col-lg-5 pt-2"> 

		<div class="card">
			<div class="card-body">

			<!-- Price -->
			<h3 class="font-weight-bold text-success">	{{ $service->price }} {{ $service->currency }}</h3>
			<br><br>
			<!-- Payment method & Duration -->
			<div class="row mt-4 justify-content-around">
				<div class="col-auto">
					<p {{ $rtl }}><i class=" fas fa-money-check-alt text-muted pr-2"></i> <a class="font-weight-bold">{{ __('service.payWith') }} {{ $service->p_method }}</a></p>
				</div>
				<div class="col-auto">
				<p {{ $rtl }}><i class="far fa-clock pr-2"></i> <a class="font-weight-bold">
					@if($service->duration == 1)
						30 - 60 {{ __('service.minutes') }}
					@elseif($service->duration == 2)
						01 - 06 {{ __('service.hours') }}
					@elseif($service->duration == 3)
						06 - 12 {{ __('service.hours') }}
					@elseif($service->duration == 4)
						12 - 24 {{ __('service.hours') }}
					@elseif($service->duration == 5)
						01 - 03 {{ __('service.days') }}
					@elseif($service->duration == 6)
						03 - 06 {{ __('service.days') }}
					@elseif($service->duration == 7)
						06 - 12 {{ __('service.days') }}
					@elseif($service->duration == 8)
						12 - 24 {{ __('service.days') }}
					@elseif($service->duration == 9)
						24 - 48 {{ __('service.days') }}
					@elseif($service->duration == 10)
						01 - 03 {{ __('service.months') }}
					@elseif($service->duration == 11)
						03 - 06 {{ __('service.months') }}
					@elseif($service->duration == 12)
						06 - 12 {{ __('service.months') }}
					@endif
				</a></p>
				</div>
			</div>
						<table class="tg w-100 text-center" {{ $rtl }}>
						  <tr>
						    <th class="tg-cly1 font-weight-bold" colspan="2">{{ __('service.serviceDetails') }}</th>
						  </tr>
						  <tr>
						    <td class="tg-0lax">{{ __('payment.purshases') }}</td>
						    <td class="tg-0lax">{{ $service->purchases_number }}</td>
						  </tr>
						  <tr>
						    <td class="tg-0lax">{{ __('payment.remaining') }}</td>
						    <td class="tg-0lax">{{ $service->remaining }}</td>
						  </tr>
						  <tr>
						    <td class="tg-0lax" colspan="2">
						    <a style="font-size: 10px;">
						    	<i id="{{$service->id}}" class="fa fa-star fa-2x" data-index="0" style="text-shadow: rgb(0, 0, 0) 0px 0px 1px; color: white;"></i>
								<i id="{{$service->id}}" class="fa fa-star fa-2x" data-index="1" style="text-shadow: rgb(0, 0, 0) 0px 0px 1px; color: white;"></i>
								<i id="{{$service->id}}" class="fa fa-star fa-2x" data-index="2" style="text-shadow: rgb(0, 0, 0) 0px 0px 1px; color: white;"></i>
								<i id="{{$service->id}}" class="fa fa-star fa-2x" data-index="3" style="text-shadow: rgb(0, 0, 0) 0px 0px 1px; color: white;"></i>
								<i id="{{$service->id}}" class="fa fa-star fa-2x" data-index="4" style="text-shadow: rgb(0, 0, 0) 0px 0px 1px; color: white;"></i>

						 		<a style="font-size: 15px; margin-left: 5px;position: relative;top: -3px;"> ({{ $service->num_raters }})</a>
						 	</a>
						 	</td>
						  </tr>
						</table>


			<!-- Continue button -->
			<div class="col text-center w-50 mx-auto mt-3">
				<button onclick="window.location.assign('{{ url('payment/confirm/'.$service->id.'') }}')" class="btn btn-lg btn-dark btn-block mx-auto">{{ __('service.continue') }}</button>
			</div>

			</div>
		</div>


		</div>
	</div>

	<!-- Description -->
	<div class="card card-body mt-3 {{ $tdir }}">	
		<h3>{{ __('service.description') }} </h3>
		<p>{!! $service->description !!}</p>
	</div>

</div>

<!-- Rating stars  -->
<script>

        function setStars(max) {
            for (var i=0; i <= max; i++){
                $('.fa-star:eq('+i+')').css('color', '#ffc100');
            }
            
        }


        	var num_stars = {{ $service->num_stars }};
        	var num_raters = {{ $service->num_raters }};
			setStars(parseInt((num_stars/num_raters)- 1));
        
          

    
</script>

@endsection()