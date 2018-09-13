@extends ('layouts.master')
@section('content')
<div class="row">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"></h3>
            <ol class="breadcrumb">
                <li><i class="fa fa-home"></i><a href="{{ url('/') }}/dashboard">{{ __('messages.home') }}</a></li>
                <li><i class="fa fa-th-list"></i><a href="{{ url('/') }}/friendlist">{{ __('messages.friends_list') }}</a></li>
                <li><i class="fa fa-th-list"><a href="{{ url('/') }}/friendrequests">{{__('messages.friend_requests')}}</a></i></li>
                <li><i class="fa fa-th-list"><a href="{{ url('/') }}/friends">{{__('messages.friends')}}</a></i></li>
            </li>
        </ol>
    </div>
</div>
<div class="box">
    <div class="col-lg-12">
        <hr />
        <h2 class="intro-text text-center"><strong>{{ __('messages.welcome') }}</strong></h2>
        <hr />
        <div class="container">
            @foreach($users_profile_data as $key=>$value)
            <!-- Single Product -->
            <div class="col-12 col-sm-6 col-lg-4">
                <!-- Product Image -->
                <img style="width:200px; height:200px;" src="" alt="" />
                <img style="width:200px; height:200px; border:1px solid grey; display: block;" src="{{ asset('public/files').'/'.$users_profile_data[$key]->profile_picture }}" alt="" />

                @endforeach
                <!-- Product Description -->
                <div class="product-description">
                    <a>
                        <h3></h3>
                    </a>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="file" name="file" id="poster"  class="form-control" />
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
</div>
</div>
@endsection