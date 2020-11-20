<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>{{ __('welcome.'.setting('site.title')) }}</title>
    <link rel="stylesheet" href="{{ asset('public/welcome/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic">
    <link rel="stylesheet" href="{{ asset('public/welcome/fonts/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('public/welcome/fonts/font-awesome.min.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Aclonica">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.css">
    <link rel="icon" href="{{ url('storage/'.setting('site.logo')) }}">
    <meta name="description" content="Safa9at is the world's largest freelance services marketplace for businesses to focus on growth & create a successful business, Safa9at Algeria">
    <meta name="og:title" property="og:title" content="Safa9at Algeria do it from your home">

    <!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-145443509-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-145443509-1');
	</script>


</head>

<body style="overflow-x: hidden;" {{ $rtl }}>


    <div class="text-right" style="background-color: #abbfda;">
        <div class="text-left position-absolute" style="max-width: 30px;left: 10px;top: 9px;">
            @if(app()->getLocale() == "en")
             @PHP($golang = "ar")
            @else
             @PHP($golang = "en")
            @endif
            <img onclick="window.location.assign('{{ url('lang/'.$golang ) }}')" src="{{ asset('img/countries/'.app()->getLocale().'.png') }}" style="max-width: 30px;cursor: pointer;"  class="rounded">
        </div>
    	<button onclick="window.location.assign('{{ url('login') }}')" class="btn btn-primary text-right btn-light" type="button" style="margin: 7px;">{{ __('welcome.signIn') }}</button>
        <button onclick="window.location.assign('{{ url('register') }}')" class="btn btn-primary text-right btn-light" type="button" style="margin: 7px;">{{ __('welcome.register') }}</button>
    </div>
    <header class="masthead text-white text-center"
        style="background: url('public/welcome/img/bg-masthead.jpg')no-repeat center center;background-size: cover;">
        <div class="row mt-2">
            <div class="col">
                <h1 style="color: rgb(80,114,150);font-size: 58px;font-family: Aclonica, sans-serif;">{{ __('welcome.safa9atAlgeria') }}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h3 style="color: rgba(80,114,150,0.6);font-size: 28px;font-family: Aclonica, sans-serif;">{{ __('welcome.doItFromYourHome') }}</h3>
            </div>
        </div>
        <div class="row m-5">
            @include('layouts.modals.video')
            <div class="col pulse animated">
                <button type="button" class="btn btn-primary video-btn" data-toggle="modal" data-src="https://www.youtube.com/embed/HDsHQLVNVzY" data-target="#myModal" style="background: none;color: inherit;border: none;padding: 0;font: inherit;cursor: pointer;outline: inherit;">
                <i class="far fa-play-circle" data-bs-hover-animate="pulse" style="font-size: 111px;color: rgba(122,150,184,0.69);opacity: 0.64;filter: blur(0px) brightness(111%) contrast(106%) grayscale(0%) hue-rotate(0deg) saturate(131%);"></i>
                </button>
            </div>
        </div>
    </header>
    <section class="features-icons bg-light text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-4" data-aos="fade" data-aos-duration="800">
                    <div class="mx-auto features-icons-item mb-5 mb-lg-0 mb-lg-3">
                        <div class="d-flex features-icons-icon"><i class="fas fa-handshake m-auto" data-bs-hover-animate="pulse" style="color: rgb(80,114,150);"></i></div>
                        <h3>{{ __('welcome.tit1') }}</h3>
                        <p class="lead mb-0">{{ __('welcome.desc1') }}</p>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade" data-aos-duration="1000" data-aos-delay="700">
                    <div class="mx-auto features-icons-item mb-5 mb-lg-0 mb-lg-3">
                        <div class="d-flex features-icons-icon"><i class="fas fa-shield-alt m-auto" data-bs-hover-animate="pulse" style="color: rgb(80,114,150);"></i></div>
                        <h3>{{ __('welcome.tit2') }}</h3>
                        <p class="lead mb-0">{{ __('welcome.desc2') }}</p>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade" data-aos-duration="1500" data-aos-delay="1000">
                    <div class="mx-auto features-icons-item mb-5 mb-lg-0 mb-lg-3">
                        <div class="d-flex features-icons-icon"><i class="far fa-id-card m-auto" data-bs-hover-animate="pulse" style="color: rgb(80,114,150);"></i></div>
                        <h3>{{ __('welcome.tit3') }}</h3>
                        <p class="lead mb-0">{{ __('welcome.desc3') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
       <h2 class="m-5 text-center" style="color: #507296">{{ __('welcome.someOfOurServices') }}...</h2>

<div class="row justify-content-center">


    @foreach($services as $service)

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

                    
                    <!-- Service Title -->
                    <h5 class="mt-3">
                    <a href="{{ url('service/'.$service->id.'') }}" class="no-under-line hover-blue" title="{{ $service->title }}" style="color:black;">{{ $service->title }}</a>
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
            <h5><a href="{{ url('service') }}" style="color: #507296">{{ __('welcome.seeAllServices') }}</a></h5>
        </div>
    </div>


<section class="testimonials text-center bg-light mt-4">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-lg-4">
                    <div class="mx-auto testimonial-item mb-5 mb-lg-0">
                        <h3>{{ __('welcome.benaliSayadAhmed') }}</h3>
                        <p class="font-weight-light mb-0">{{ __('welcome.owner') }}</p>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="call-to-action text-white text-center" style="background:url(&quot;{{ asset('public/welcome/img/bg-masthead.jpg')}}&quot;) no-repeat center center;background-size:cover;">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-9 mx-auto">
                    <h2 class="mb-4">{{ __('welcome.readyToGetStarted') }}</h2>
                </div>

                <div class="col-xl-5 mx-auto">
                    <a class="btn btn-primary btn-block btn-lg" href="{{ url('register') }}">{{ __('welcome.signUp') }}</a>
                </div>
            </div>
        </div>
    </section>


    <footer class="footer bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 my-auto h-100 text-center text-lg-left">
                    <ul class="list-inline mb-2">
                        <li class="list-inline-item"><a href="#">{{ __('welcome.about') }}</a></li>
                        <li class="list-inline-item"><span>⋅</span></li>
                        <li class="list-inline-item"><a href="#">{{ __('welcome.contact') }}</a></li>
                        <li class="list-inline-item"><span>⋅</span></li>
                        <li class="list-inline-item"><a href="#">{{ __('welcome.termOfUse') }}</a></li>
                        <li class="list-inline-item"><span>⋅</span></li>
                        <li class="list-inline-item"><a href="#">{{ __('welcome.privacyPolicy') }}</a></li>
                    </ul>
                    <p class="text-muted small mb-4 mb-lg-0">{{ __('welcome.allRightReserved') }}</p>
                </div>
                <div class="col-lg-6 my-auto h-100 text-center text-lg-right">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="#"><i class="fa fa-facebook fa-2x fa-fw"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-twitter fa-2x fa-fw"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-instagram fa-2x fa-fw"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <div></div>


    <script src="{{ asset('public/welcome/js/jquery.min.js')}}"></script>
    <script src="{{ asset('public/welcome/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('public/welcome/js/bs-animation.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>


    <script type="text/javascript">
$(document).ready(function() {

// Gets the video src from the data-src on each button

var $videoSrc;  
$('.video-btn').click(function() {
    $videoSrc = $(this).data( "src" );
});
console.log($videoSrc);

  
  
// when the modal is opened autoplay it  
$('#myModal').on('shown.bs.modal', function (e) {
    
// set the video src to autoplay and not to show related video. Youtube related video is like a box of chocolates... you never know what you're gonna get
$("#video").attr('src',$videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0" ); 
})
  


// stop playing the youtube video when I close the modal
$('#myModal').on('hide.bs.modal', function (e) {
    // a poor man's stop video
    $("#video").attr('src',$videoSrc); 
}) 
    
    


  
  
// document ready  
});



</script>

</body>

</html>