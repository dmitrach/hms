<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
            @yield('title') 
        @else
            {{ config('app.name', 'HMS') }}
        @endif
    </title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet">
   
</head>
<body>
    <div id="app">
        @include('layouts.navigation')
        @section('navigation')
            This is main menu
        @show
        
        <div class="container">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <!--script src="{{ asset('js/app.js') }}"></script-->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>    
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script> 
</body>
</html>
