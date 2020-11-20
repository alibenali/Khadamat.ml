@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header {{$tdir}}">{{ __('verify.verifyYourEmailAddress') }}</div>

                <div class="card-body" {{$tdir}}>
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('verify.emailHasBeenSent') }}
                        </div>
                    @endif

                   {{ __('verify.verifyEmailDetails') }} <a href="{{ route('verification.resend') }}">{{ __('verify.aotherRequest') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
