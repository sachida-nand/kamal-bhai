<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="@yield('meta_tag')">
    <meta name="description" content="@yield('meta_desc')">
    <title>@yield('title-section')</title>
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> --}}
    <link href="{{ asset('css/app.css')}}" rel="stylesheet">
    <link href="{{ asset('adminAssets/vendors/font-awesome/css/all.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('frontEndAssets/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('frontEndAssets/css/orders.css')}}">
    <link rel="stylesheet" href="{{ asset('frontEndAssets/css/account.css')}}">
   
</head>
 <body>
    <main>
        @include('layouts.frontEndNavbar')
        @yield('content')
        @include('layouts.frontEndFooter')
    </main>
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
     <script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
     <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> --}}
    <script src="{{ asset('adminAssets/vendors/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('adminAssets/vendors/font-awesome/js/all.min.js')}}"></script>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <script src="{{ asset('frontEndAssets/zoom/zoomsl.min.js') }}"></script>
    <script src="{{ asset('frontEndAssets/js/app.js')}}"></script>
    <script src="{{ asset('frontEndAssets/js/checkApp.js')}}"></script>
    <script src="{{ asset('frontEndAssets/js/formvalidation.js') }}"></script>
    <script src="{{ asset('frontEndAssets/js/frontEndAajaxCalling.js')}}"></script>
    @yield('script')
</body>
</html>