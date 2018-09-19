@extends('layouts.app')
@section('count')
{{ $count }}
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
		@if(isset($users))
		@foreach ($users as $key => $value)
		@if($users[$key]['id'] == Auth::user()->id)
		@else
		@if($users[$key]['status'] == 3 || $users[$key]['status'] == 2 )
		@else
		<div class="col-sm-4">
			<div class="card" >
				<div class="card-body">
					<h4 class="card-title">{{ ucwords($users[$key]['name']) }}</h4>
					@if($users[$key]['status'] == 0)
					<a href="{{url('cancel/'.$users[$key]['id'])}}" class="btn btn-danger">Cancel Request</a>
					@else
					<a href="{{url('add/'.$users[$key]['id'])}}" class="btn btn-primary">Add Friend</a>
					@endif
				</div>
			</div>
			<hr />
		</div>
		@endif
		@endif
		@endforeach
		@endif
	</div>
</div>
@endsection
