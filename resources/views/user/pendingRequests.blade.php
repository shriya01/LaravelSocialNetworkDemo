@extends('layouts.app')
@section('count')
{{ $count }}
@endsection
@section('friends_count')
{{ $friends_count }}
@endsection
@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			@if (session('status'))
			<div class="alert alert-success" role="alert">
				{{ session('status') }}
			</div>
			@endif
		</div>
		<div class="col-md-8">
			@if (session('success'))
			<div class="alert alert-success" role="alert">
				{{ session('success') }}
			</div>
			@endif
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		@foreach ($user_records as $key => $value)
		@if($user_records[$key]['id'] != Auth::user()->id)
		<div class="col-sm-4">
			<div class="card" >
				<div class="card-body">
					<h4 class="card-title">{{ ucwords($user_records[$key]['name']) }}</h4>
					<a href="{{url('confirm/'.$user_records[$key]['id'])}}" class="btn btn-primary">Confirm Request</a>
					<a href="{{url('reject/'.$user_records[$key]['id'])}}" class="btn btn-danger">Delete Request</a>
				</div>
			</div>
		</div>
		@endif
		@endforeach
	</div>
</div>
@endsection
