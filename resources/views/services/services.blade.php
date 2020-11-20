@extends('layouts/app')

@section('content')

<div class="container">
	<div class="row justify-content-center">
	@foreach($services as $service)

	<script type="text/javascript">
		$(document).ready(function () { initStars({{$service->num_raters}}, {{$service->num_stars}}, {{$service->id}}); });
	</script>
		<div class="col">
				<div class="card mx-auto mt-5" style="width: 20rem;">
				<a href="{{ url('service/'.$service->id.'') }}" class="no-under-line">
					<img src="{{ asset('storage/'.$service->img_path.'') }}" class="img-fluid border-bottom" alt="Responsive image" style="width: 100%; height: 12rem;" />
				</a>
				<div class="pl-3 pr-3 pt-2 pb-1">

					<!-- Avatar -->
					<a href="{{ url('user/'.$service->user->id) }}" class="no-under-line">
						<img src="{{ url('storage/'.$service->user->avatar) }}" class="img-fluid d-inline" style="width: 25px;height: 25px;border-radius: 50%;">
					</a>

					<!-- Creator Name -->
					<a href="{{ url('user/'.$service->user->id) }}" class="m-2 d-inline no-under-line text-dark p-0" title="Server name" style="font-size: 13px;">{{ $service->user->name }}</a>

					<h6  class=" d-inline no-under-line p-0 float-right m-1"  style="font-size: 7px;">
						
						<i id="{{$service->id}}" class="fa fa-star fa-2x" data-index="0" style="text-shadow: rgb(0, 0, 0) 0px 0px 1px; color: white;"></i>
						<i id="{{$service->id}}" class="fa fa-star fa-2x" data-index="1" style="text-shadow: rgb(0, 0, 0) 0px 0px 1px; color: white;"></i>
						<i id="{{$service->id}}" class="fa fa-star fa-2x" data-index="2" style="text-shadow: rgb(0, 0, 0) 0px 0px 1px; color: white;"></i>
						<i id="{{$service->id}}" class="fa fa-star fa-2x" data-index="3" style="text-shadow: rgb(0, 0, 0) 0px 0px 1px; color: white;"></i>
						<i id="{{$service->id}}" class="fa fa-star fa-2x" data-index="4" style="text-shadow: rgb(0, 0, 0) 0px 0px 1px; color: white;"></i>

						 <a style="font-size: 14px; margin-left: 2px;"> ({{ $service->num_raters }})</a>
					</h6>
	
					<!-- Service Title -->
					<h5 class="mt-3">
					<a href="{{ url('service/'.$service->id.'') }}" class="no-under-line hover-blue" title="{{ $service->title }}" style="color:black;"> {{ str_limit($service->title, 50) }}
</a>
					</h5>

				</div>

				<div class="card-footer bg-white mt-3">
					<a><small>STARTING AT</small> <a class="font-weight-bold text-muted" style="font-size: 16px;">{{ $service->price.' '.$service->currency }}</a></a>
				</div>

				</div>
		</div>
	@endforeach

	</div>

	<div class="row ">
		<div class="col-12 mt-3 d-flex justify-content-center">
			{{ $services->links() }}
		</div>
	</div>

</div>



<!-- Rating stars  -->
<script>
        function setStars(max, id) {
            for (var i=0; i <= max; i++){
                $('#'+id+'.fa-star:eq('+i+')').css('color', '#ffc100');
            }
        }

        function initStars(num_raters, num_stars, id){
        if(num_raters > 0){
			setStars(parseInt((num_stars/num_raters)- 1), id);
        }
        }
</script>

@endsection()