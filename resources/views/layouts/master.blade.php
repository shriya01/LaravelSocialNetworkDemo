<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">	
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('public/frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/css/font-awesome.min.css') }}" rel="stylesheet" />
</head>
<body>
    @include('includes.header')    
    <div id="flags" class="text-center"></div>     
    <main role="main" class="container">
        @guest
        @else
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header"></h3>
                <ol class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="{{ url('/') }}/dashboard">{{ __('messages.home') }}</a></li>
                    <li><i class="fa fa-th-list"></i><a href="{{ url('/') }}/friendlist">{{ __('messages.friends_list') }}</a></li>
                    <li><i class="fa fa-th-list"><a href="{{ url('/') }}/friendrequests">{{__('messages.friend_requests')}}</a></i></li>
                    <li><i class="fa fa-th-list"><a href="{{ url('/') }}/friends">{{__('messages.friends')}}</a></i></li>
                </ol>
            </div>
        </div>
        @endguest
        @yield('content')
    </main>
    @include('includes.footer')      
    @yield('scripts')
</body>
</html>
