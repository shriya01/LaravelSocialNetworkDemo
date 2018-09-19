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
	<a href="{{'addPost'}}" class="btn btn-primary"> ADD NEW POST</a>
	<hr />
	<div class="row">
		<?php $count= count($posts); ?>
		@for($i=0; $i<$count; $i++)
		@foreach ($posts[$i] as $key => $value)
		<div class="col-sm-4">
			<div class="card" >
				<div class="card-body">
					<h4 class="card-title">{{$posts[$i][$key]['post_title']}}</h4>
					<p>{{$posts[$i][$key]['post_description']}}</p>				
				</div>
			</div>
		</div>
		@endforeach
		@endfor
	</div>
</div>
@endsection
