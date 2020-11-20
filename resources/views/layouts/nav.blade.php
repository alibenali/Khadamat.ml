<link rel="stylesheet" type="text/css" href="{{ asset('css/search_input.css') }}">

<nav class="navbar navbar-expand-md navbar-light bg-white">
                <a class="navbar-brand" href="{{ url('/') }}" style="font-size: 30px;">
                    {{ setting('site.title') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto" {{ $rtl }}>

                    	<div class="dropdown">
						<input type="text" placeholder="Search.." id="searchInput" class="b-0 shadow-sm" >

						  <div id="myDropdown" class="dropdown-content" style="display: none;">
						    
						    <div id="searchOptions" style="display:none;">

						    </div>
						  </div>
						</div>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('navbar.login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('navbar.register') }}</a>
                                </li>
                            @endif
                        @else


                            

                            <li class="nav-item mt-1 mr-2">
                                @if(Auth::user()->hasRole('server'))
                                <a class="nav-link text-success"  href="{{ url('server') }}">{{ __('navbar.switchToSelling') }} <span class="sr-only">(current)</span></a>
                                @endif
                            </li>

                            
                            <li class="nav-item mt-1 mr-2">
                                <a class="nav-link " href="{{ url('cart') }}">
                                   
                                    @if($num_carts > 0) <span class="badge badge-danger rounded-circle" style="position: absolute;font-size: 9px;"> {{ $num_carts }} </span>  @endif

                                   <h3><i class="fas fa-shopping-cart"></i></h3>
                                </a>
                            </li>
                            

                            <li class="nav-item dropdown mt-1 mr-2 ">

                                <a class="nav-link " href="#" id="navbarDropdown_notification" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                   @if($not_seen_notification > 0)<span class="badge badge-danger rounded-circle" id="notSeen" style="position: absolute;font-size: 9px;">{{ $not_seen_notification }}</span> @endif
                                  
                                   <h3><i class="far fa-bell"></i> </h3>
                                   
                                </a>

                                <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="navbarDropdown_notification" style="width: 270px;height: auto;max-height: 350px;overflow-x: hidden;">

                                    @if(count($notifications) > 0)
                                    <a href="{{ url('notification') }}" class="pl-2">{{ __('navbar.seeAll') }}</a>
                                    @else
                                        <div class="dropdown-item p-2 border-top">
                                            <p class="mb-0" style="white-space: initial !important;">{{ __('navbar.noNotifications') }}</p>
                                        </div>
                                    @endif

                                    @foreach($notifications as $notification)
                                        <div class="dropdown-item p-2 border-top text-right" onclick="window.location.assign('{{ $notification->url }}')" 
                                            style="@if($notification->seen == 0)
                                            background-color: #c4c3c336;
                                            @endif
                                            ">

                                            <p class="mb-0 text-left {{ $tdir }}" style="white-space: initial !important;">{{ substr( __('notiMessage.'.$notification->title), 0, 80) }}
                                            @if(strlen($notification->title) > 80) ... @endif
                                            </p>
                                            <small>{{ $notification->created_at }}</small>
                                        </div>
                                    @endforeach
                                </div>
                            </li>


                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre >
                                    
                                    
                                    <img src="{{ url('storage/'.Auth::user()->avatar) }}" class="img-fluid d-inline rounded-circle " style="width: 34px;height: 34px;border-radius: 50%;">
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" {{ $rtl }}>
                                                                        
                                    <a class="dropdown-item {{ $tdir }}" href="{{ route('home') }}">{{ __('navbar.profile') }}</a>
                                    <a class="dropdown-item {{ $tdir }}" href="{{ route('balanceHistory') }}">{{ __('navbar.balanceHistory') }}</a>
                                    <a class="dropdown-item {{ $tdir }}" href="{{ route('deposit.index') }}">{{ __('navbar.deposit') }}</a>
                                    <a class="dropdown-item {{ $tdir }}" href="{{ url('payment') }}">{{ __('navbar.payment') }}</a>
                                    <a class="dropdown-item {{ $tdir }}" href="{{ route('withdraw.index') }}">{{ __('navbar.withdraw') }}</a>
                                    <a class="dropdown-item {{ $tdir }}" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('navbar.logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>

                            
                        @endguest
                    </ul>
                </div>
        </nav>


<ul class="navbar-nav {{$tdir}} p-2 bg-white border" {{ $rtl }}>
	{{ menu('navbar', 'layouts.menu-navbar') }}
</ul>

     <script>

            $( "#navbarDropdown_notification" ).click(function() {
                $.post( "{{ action('NotificationController@seen') }}", { _token: "{{ csrf_token() }}" } );
                $("#notSeen").hide();

            });

		/* Search input */




//setup before functions
var typingTimer;                //timer identifier
var doneTypingInterval = 400;  //time in ms, 5 second for example
var $input = $('#searchInput');

//on keyup, start the countdown
$input.on('keyup', function () {
  clearTimeout(typingTimer);
  typingTimer = setTimeout(doneTyping, doneTypingInterval);
});

//on keydown, clear the countdown 
$input.on('keydown', function () {
  clearTimeout(typingTimer);
	$('#searchOptions').html('<a>...</a>');

});

//user is "finished typing," do something
function doneTyping () {


		   	var searchInputValue = document.getElementById('searchInput').value;
		    var searchOptions = document.getElementById('searchOptions');
			var dropDown = document.getElementById('myDropdown');

			if(searchInputValue.length == 0){
			  	searchOptions.style.display = "none";
				dropDown.style.display = "none";

			  }else{
			  	searchOptions.style.display = "initial";
			  	dropDown.style.display = "initial";
			  }


			// Fetch

		   var _token = $('input[name="_token"]').val();
		   $.ajax({
		    url:"{{ route('search.fetch') }}",
		    method:"POST",
		    data:{searchInputValue:searchInputValue, _token:_token},
		    success:function(result)
		    {
		     $('#searchOptions').html(result);
		    }

			});
}
		

     </script>
