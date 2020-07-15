<!DOCTYPE html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>

    <title>{{ config('app.name', 'Laravel') }}</title>    

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">    

    <!-- Scripts -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper" id="app">

        @auth
            
            @include('partials.navbar')             <!-- Navigation bar -->        

            @include('partials.menu_sidebar')       Main Sidebar Container        

            <div id="app2">

                @include('partials.content')            <!-- Content Wrapper. Contains page content -->
     
                @include('partials.control_sidebar')    <!-- Control Sidebar -->        
                
            </div>                

            @include('partials.footer')    <!-- Main Footer -->    
            <script>
                window.api_token = "{{ Auth::user()->api_token}}"
            </script>
        @else
            @include('partials.login')
        @endauth
    </div>

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>

    @stack('scripts')
</body>
</html>
