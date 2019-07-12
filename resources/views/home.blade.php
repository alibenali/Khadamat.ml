@extends('layouts.app')


@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')

<div class="container emp-profile">


            <form method="post">
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img">
            				<img src="{{ asset('img/profiles/default-account.jpg') }}" width="200" class="rounded-circle  border border-gray">
                            <div class="file btn btn-lg">
                                <i class="fas fa-camera text-secondary"></i></h5>
                                <input type="file" name="file"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-head">
                                    <h3>
                                        {{Auth::user()->name}}
                                    </h3>
                                    <p class="proile-rating">SERIOUSNESS : <span>{{ Auth::user()->seriousness }}</span></p>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Balance</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false" title="Personal information">About</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2">
                    </div>
                </div>
            </form>           

                <div class="row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-8">

                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        
                                        @if($balance == NULL)
                                        <button type="button" class="btn btn-lg btn-primary" data-toggle="modal" data-target="#exampleModalLong">Create currencies</button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                          <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Terms & Conditions</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                ...
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                                <form method="POST" action="{{ url('balance') }}">
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-primary">Accept</button>
                                                </form>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        @else

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>CCP</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><a class="font-weight-bold text-dark">{{ $balance->ccp_dinar }}</a> DA</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Paypal</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><a class="font-weight-bold text-dark">{{ $balance->paypal_usd }}</a> USD &nbsp;&nbsp; | &nbsp;&nbsp; <a class="font-weight-bold text-dark">{{ $balance->paypal_euro }}</a> Euro</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Paysera</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><a class="font-weight-bold text-dark">{{ $balance->paysera_usd }}</a> USD &nbsp;&nbsp; | &nbsp;&nbsp; <a class="font-weight-bold text-dark">{{ $balance->paysera_euro }}</a> Euro</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                @if($balance->hold_ccp_dinar > 0)
                                                <hr><label class="mr-2 p-2 border-left border-3">{{$balance->hold_ccp_dinar}} Da in hold</label>
                                                @endif
                                                @if($balance->hold_paypal_usd > 0)
                                                <hr><label class="mr-2 p-2 border-left border-3">{{$balance->hold_paypal_usd}} USD Paypal in hold</label>
                                                @endif
                                                @if($balance->hold_paypal_euro > 0)
                                                <hr><label class="mr-2 p-2 border-left border-3">{{$balance->hold_paypal_euro}} Euro Paypal in hold</label>
                                                @endif
                                                @if($balance->hold_paysera_usd > 0)
                                                <hr><label class="mr-2 p-2 border-left border-3">{{$balance->hold_paysera_usd}} USD Paysera in hold</label>
                                                @endif
                                                @if($balance->hold_paysera_euro > 0)
                                                <hr><label class="mr-2 p-2 border-left border-3">{{$balance->hold_paysera_euro}} Euro Paysera in hold</label>
                                                @endif

                                            </div>
                                            <div class="col-md-6">
                                            </div>
                                        </div>
                                        @endif
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Full name</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{Auth::user()->name}}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{ Auth::user()->email }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Phone</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>@if(Auth::user()->phone === NULL) No Phone @else {{Auth::user()->phone}}  @endif</p>
                                            </div>
                                        </div>
									<input type="submit" onclick="window.location.href=('{{ url('profile/'.Auth::id().'/edit') }}')" class="profile-edit-btn mt-4" name="btnAddMore" value="Edit Profile"/>
   
                            </div>
                        </div>
                    </div>
                </div>
        </div>


@endsection
