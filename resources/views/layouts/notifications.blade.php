        @if(session()->has('danger'))
            <div class="alert alert-danger">
                {{ session()->get('danger') }}
            </div>
        @endif

        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif


        @if(count($errors))
        <div class="alert alert-danger" role="alert">
        	<ul>
        		@foreach($errors->all() as $message)
        		<li>
        			{{ $message }}
        		</li>
        		@endforeach
        	</ul>
        </div>
        @endif