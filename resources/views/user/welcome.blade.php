@extends ('layouts.master')
@section('content')
<div class="container">
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
</div>
</div>
@endsection