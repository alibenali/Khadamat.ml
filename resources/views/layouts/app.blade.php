<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>



    <!-- Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


    <!-- Datatable -->
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>



    <!-- Scripts 
    <script src="{{ asset('js/app.js') }}" defer></script> -->
    @yield('js')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Tajawal&display=swap" rel="stylesheet">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap_add.css') }}" rel="stylesheet">
    @yield('css')
    <style>
            @media (max-width: 767px) {
            .dropdown-menu{
                position: absolute !important;
            }


                div#navbarSupportedContent {
        flex-direction: column;
    }
            ul.navbar-nav.ml-auto {
        margin-left: 0!important;
        text-align: center;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: center;
    }
    ul.navbar-nav.ml-auto li {
        margin-right: 0!important;
        display: inline-block;
        padding: 0 10px;
    }
    ul.navbar-nav.ml-auto li.full-width-item {
        width: 100%;
        padding: 0;
        text-align: center;
    }
    ul.navbar-nav.mr-auto {
        margin-right: 0!important;
        order: 2;
    }
                }
            </style>

            <!-- Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

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
<body>
    <div id="app">

            @if(!isset($server))
                @include('layouts.nav')
            @else
                @include('layouts.server-nav')
            @endif

        	@include('layouts.notifications')
            @include('layouts.loader')

        <main class="py-4">
            @yield('content')

            <div class="fixed-bottom">
                <select class="custom-select custom-select-sm w-auto float-right" onchange="location = this.value;">
                  <option selected>Language</option>
                  <option value="{{ url('lang/en') }}">English</option>
                  <option value="{{ url('lang/ar') }}">عربية</option>
                  <option value="{{ url('lang/fr') }}">Francais</option>
                </select>
            </div>
        </main>

        

    </div>


<div id='tawk_5c2ac7287a79fc1bddf2d236'></div>
<!--Start of Tawk.to Script-->
<script type="text/javascript">

@if(isset($user))
var Tawk_API=Tawk_API||{};
Tawk_API.visitor = {
name : '{{ $user->name }}',
email : '{{ $user->email }}',
hash : '{{hash_hmac("sha256",$user->email,"bfef407586ecb06b353a411c2b4ae47cbd1bb657")}}'
};

var Tawk_LoadStart=new Date();
<!-- rest of the tawk.to widget code -->
@endif

var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5c2ac7287a79fc1bddf2d236/1djmfo4sr';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->

</body>
</html>
