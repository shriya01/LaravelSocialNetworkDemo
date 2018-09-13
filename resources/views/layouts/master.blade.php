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
        @yield('content')
    </main>
    @include('includes.footer')      
    @yield('scripts')
</body>
</html>
