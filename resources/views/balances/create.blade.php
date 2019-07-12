@extends('layouts.app')


@section('content')

<div class="container">

	<div class="alert alert-primary">You don't have a balance yet, Please create a new balance.</div>

	<div class="card col-md-6 mx-auto">
		<div class="card-body">
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
		</div>
	</div>
</div>

@endsection