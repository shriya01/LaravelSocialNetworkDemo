@extends ('layouts.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"></h3>
            <ol class="breadcrumb">
                <li><i class="fa fa-home"></i><a href="{{ url('/') }}/dashboard">{{ __('messages.home') }}</a></li>
                <li><i class="fa fa-th-list"></i><a href="{{ url('/') }}/friendlist">{{ __('messages.friends_list') }}</a></li>
                </li>
            </ol>
        </div>
    </div>
	<?php 
	$i=0;
	?>
	@if (session('success'))
	<div class="alert alert-success">
		{{ session('success') }}
	</div>
	@endif
	<div class="box">
<?php 
echo "<pre>";
print_r($users);
echo "</pre>";
?>
		<!-- Single Product -->
		<div class="col-12 col-sm-6 col-lg-4">
			@foreach($users as $key => $row)
			<!-- Product Image -->
			<img style="width:200px; height:200px; border:1px solid grey; display: block;" src="" alt="" />
			<!-- Product Description -->
			<div class="product-description">
				<a>
					<h3>{{$row->user_first_name }}&nbsp;{{$row->user_last_name }}</h3>
				</a>
				@if(isset($row->status) && $row->status == 0 && isset($row->sender_id) && $row->sender_id == Auth::user()->id)
				<a href="{{url('cancel',$row->id)}}"><button class="btn btn-default">Cancel Request</button></a>
				@else
				<a href="{{url('add',$row->id)}}"><button class="btn btn-default">Add Friend</button></a>
				@endif
			</div>
			<hr />
			<?php
			$i++;
			?>
			@endforeach
		</div>

	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$('div.alert').delay(3000).slideUp(300);
</script>
@endsection