@extends('layouts.app')
@section('count')
{{ $count }}
@endsection
@section('friends_count')
{{ $friends_count }}
@endsection
@section('styles')
<style type="text/css">
	.social-button
	{
		float:inline-end;
	}
	.social-links ul li
	{
		list-style-type: none;
	}
	a[class*="social-button"]:after {content: ' Share ';}
</style>
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
<div class="container container-fluid gedf-wrapper" >
	<div class="row gedf-main">
		<a href="{{'addPost'}}" class="btn btn-primary">ADD NEW POST</a>
	</div>
	<hr />
	<div class="row">
		<div class="col-sm-8 gedf-main">
			<div class="row">
				<?php $count= count($posts); ?>
				@foreach ($posts as $key => $value)
				<div class="card gedf-card" style="width:100%;">
					<div class="card-header">
						<div class="d-flex justify-content-between align-items-center">
							<div class="d-flex justify-content-between align-items-center">
								<div class="mr-2">
									<img class="rounded-circle" width="45" src="https://picsum.photos/50/50" alt="">
								</div>
								<div class="ml-2">
									<div class="h5 m-0">{{ ucwords($posts[$key]['name']) }}</div>
								</div>
							</div>
							<div>
								<div class="dropdown">
									<button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="fa fa-ellipsis-h"></i>
									</button>
									<div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
										<div class="h6 dropdown-header">Configuration</div>
										<a class="dropdown-item" href="#">Save</a>
										<a class="dropdown-item" href="#">Hide</a>
										<a class="dropdown-item" href="#">Report</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="text-muted h7 mb-2"> <i class="fa fa-clock-o"></i>10 min ago</div>
						<a class="card-link" href="#">
							<h5 class="card-title">{{$posts[$key]['post_title']}}</h5>
						</a>
						<p class="card-text">
							{{$posts[$key]['post_description']}}
						</p>
						@if(!empty($posts[$key]['post_image']))
						<img class="card-img-bottom" src="{{asset('public/files/'.$posts[$key]['post_image'])}}"  style="width:50%">
						@endif
					</div>
					<div class="card-footer">
						<a href="#" class="card-link card-link-like" id="card-link-like{{$posts[$key]['id']}}" data-id="{{$posts[$key]['id']}}"><i class="fa fa-gittip"></i>Like</a>
						@if($posts[$key]['likes'] > 0)
						<span id="likebadge{{$posts[$key]['id']}}" class="badge">{{$posts[$key]['likes']}}</span>
						@endif		
						</a>
						<a href="#" class="card-link card-link-comment" data-id="{{$posts[$key]['id']}}"><i class="fa fa-comment" ></i> Comment 
							@if($posts[$key]['comments'] > 0)
							<span id="commentbadge{{$posts[$key]['id']}}">{{$posts[$key]['comments']}}</span>
							@endif
						</a>
						<div style="display:none" class="card-link-comment-form" id="card-link-comment{{$posts[$key]['id']}}">
							<form action='' method="post" id="comment-form{{$posts[$key]['id']}}">
								@csrf
								<input type="text" name="comment_text" id="comment_text{{$posts[$key]['id']}}" placeholder="Comment Here">
								<input type="submit" name="addComment" value="Comment" class="ajaxSubmit btn btn-primary" data-id="{{$posts[$key]['id']}}">
							</form>
						</div>
						<br/>
						@if($posts[$key]['comments_data'])
						@foreach($posts[$key]['comments_data'] as $commentkey => $commentvalue)
						<ul class="list-group">
						<input type="text" name="comment_text" readonly="" value="{{ $commentvalue->comment  }}">
							@endforeach
						</ul> 
						<div class="social-links">
				{!! $result !!}
				</div>
						@endif
					</div>
				</div>
				
				@endforeach
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function() {
		var value = attrid ='';
		jQuery('.card-link-like').click(function() {
			textValue = $(this).text();
			postId = $(this).attr("data-id");
			jQuery.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			jQuery.ajax({
				url: "{{ route('posts/likechange') }}",
				type: 'post',
				data: {
					id:textValue,
					attrid:postId
				},
				success: function(result) {
					var json = JSON.parse(result);
					$('#card-link-like'+postId).text(json.text);
					$("#likebadge"+postId).text(json.likes);
				},
			});
		});
	});
</script>
<script type="text/javascript">
	jQuery(document).ready(function() {
		var postId ='';
		jQuery('.card-link-comment').click(function() {
			postId = $(this).attr("data-id");
			$('#card-link-comment'+postId).show();
		});
		jQuery('.ajaxSubmit').click(function(e){
			e.preventDefault();
			postId = $(this).attr("data-id");
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			jQuery.ajax({
				url: "{{ route('posts/addComment') }}",
				type: 'post',
				data: {
					comment: jQuery('#comment_text'+postId).val(),
					postId:postId
				},
				success: function(result){
					var json = JSON.parse(result);
					$("#commentbadge"+postId).text(json.comments);
					$("#comment-form"+postId)[0].reset();
					location.reload();
				},
			});
		});
	});
</script>
@endsection