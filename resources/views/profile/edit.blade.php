@extends('layouts.app')


@section('content')

<div class="container">
    <h1>Edit Profile</h1>
  	<hr>
	<div class="row">
      <!-- left column -->
      <div class="col-md-3">
        <div class="text-center">
          <img src="{{ asset($user->img_path) }}" class="avatar img-circle" alt="avatar" width="100" height="100">          
          <input type="file" class="form-control">
        </div>
      </div>
      
      <!-- edit form column -->
      <div class="col-md-9 personal-info">
        
        <form class="form-horizontal mt-4" role="form" method="POST" action="{{ url('profile/'. Auth::id() ) }}">
          @method('PUT')
          @csrf
          <div class="form-group">
            <label class="col-lg-3 control-label">First & Last Name:</label>
            <div class="col-lg-8">
              <input name="name" class="form-control" type="text" value="{{ $user->name }}">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Phone:</label>
            <div class="col-lg-8">
              <input name="phone" class="form-control" type="number" value="{{ $user->phone }}">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Email:</label>
            <div class="col-lg-8">
              <input name="email" class="form-control" type="email" value="{{ $user->email }}">
            </div>
          </div>
          
          
          <div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-8">
              <input type="submit" class="btn btn-primary" value="Save Changes">
              <span></span>
              <input type="reset" class="btn btn-default" value="Cancel">
            </div>
          </div>
        </form>
      </div>
  </div>
</div>
<hr>

@endsection