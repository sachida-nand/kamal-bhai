<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title-section')</title>

    <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link href="{{ asset('adminAssets/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('adminAssets/vendors/font-awesome/css/all.min.css')}}" rel="stylesheet">
    <link href="{{ asset('adminAssets/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <link href="{{ asset('adminAssets/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
    <link href="{{ asset('adminAssets/vendors/jQuery-Tags-Input/dist/jquery-tagsinput.min.css')}}" rel="stylesheet">
    <link href="{{ asset('adminAssets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('adminAssets/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('adminAssets/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('adminAssets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('adminAssets/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('adminAssets/vendors/bootstrap-select/css/bootstrap-select.min.css')}}" rel="stylesheet">
    <script src="{{ asset('adminAssets/vendors/ckeditor/ckeditor.js')}}"></script>
    <!-- Custom Theme Style -->
    <link href="{{ asset('adminAssets/build/css/custom.min.css')}}" rel="stylesheet">
    <link href="{{ asset('adminAssets/css/admin_all_style.css')}}" rel="stylesheet">
</head>
<body class="nav-md">
    <div class="container body">
        <div class="main_container">
           <main>
               @include('layouts.adminnavbar')
               @yield('content')
           </main>
        </div>
    </div>
 
    <script src="{{ asset('adminAssets/vendors/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{ asset('adminAssets/vendors/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('adminAssets/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('adminAssets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{ asset('adminAssets/vendors/font-awesome/css/all.min.js')}}"></script>
    <script src="{{ asset('adminAssets/vendors/jQuery-Tags-Input/dist/jquery-tagsinput.min.js')}}"></script>
    <script src="{{ asset('adminAssets/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('adminAssets/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{ asset('adminAssets/vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{ asset('adminAssets/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('adminAssets/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{ asset('adminAssets/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{ asset('adminAssets/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{ asset('adminAssets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{ asset('adminAssets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
    <script src="{{ asset('adminAssets/vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script> 
    <script src="{{ asset('adminAssets/vendors/bootstrap-select/js/bootstrap-select.min.js')}}"></script> 
    <!-- Custom Theme Scripts -->
    <script src="{{ asset('adminAssets/build/js/custom.min.js') }}"></script>
    <script src="{{ asset('adminAssets/js/ajaxCalling.js') }}"></script>
    <script src="{{ asset('adminAssets/js/admin_main.js') }}"></script>
    @yield('script')
    <script>
        $(function () {
                $('[data-toggle="tooltip"]').tooltip()
          });

        $('#tags').tagsInput();
    </script>
</body>
</html>





{{-- <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html> --}}
