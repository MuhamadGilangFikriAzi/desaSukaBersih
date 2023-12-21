<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Web Desa Suka Bersih</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/summernote/summernote-bs4.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    {{-- Font for tinymce --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Oswald&display=swap');
    </style>

    <!-- Core JS files -->
    <script src="{{ url('limitless/global_assets/js/main/jquery.min.js') }}"></script>
    <script src="{{ url('limitless/global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('limitless/global_assets/js/plugins/loaders/blockui.min.js') }}"></script>
    <script src="{{ url('limitless/global_assets/js/plugins/ui/ripple.min.js') }}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{ url('limitless/global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    @yield('script_before_app')

    <script src="{{ url('limitless/assets/js/app.js') }}"></script>
    @yield('head_theme_script')
    <!-- /theme JS files -->

    {{-- Editor --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/classic/ckeditor.js"></script>
    <!-- Plug in JS -->
    <script src="{{ url('js/BrowserPrint-1.0.4.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('js/DevDemo.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ url('webcamjs/webcam.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
    <script type="text/javascript">
        $(document).ready(setup_web_print);
    </script>
    {{-- <script src="{{ url('js/build/ckeditor.js') }}"></script> --}}
    <script src="https://cdn.tiny.cloud/1/lay6ickwk8ow14zhlwnva7j60vzbeubnrysij6x10v6hver5/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    {{-- Sweat Allert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="hold-transition sidebar-mini layout-fixed" style="height: auto;">
    <div class="wrapper">
        <div id="app">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-dark navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>
                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <!-- Messages Dropdown Menu -->
                        <div class="nav-item dropdown">
                            <a class="nav-link" data-toggle="dropdown" href="#">
                                {{ Auth::user()->name }} <i class="fas fa-angle-down"></i>
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('edit_prof', Auth::user()->id) }}">Edit
                                    Profile</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @endguest
                </ul>
            </nav>

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="#" class="brand-link">
                    <img src="{{ asset('img/kab-logo.png') }}" alt="img"
                        class="brand-image img-circle elevation-3"
                        style="opacity: .8; background: transparant !important">
                    <span class="brand-text font-weight-light">Web Desa Suka Bersih</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->
                            <li class="nav-item has-treeview">
                                <a href="{{ url('/home') }}"
                                    class="nav-link @if (Request::is('home/*') || Request::is('home')) active @endif">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>

                            @role('Staff Desa')
                                <li class="nav-item">
                                    <a href="{{ route('templatesurat') }}"
                                        class="nav-link @if (Request::is('templatesurat/*') || Request::is('templatesurat')) active @endif">
                                        <i class="fas fa-clipboard-list nav-icon"></i>
                                        <p>Template Surat</p>
                                    </a>
                                </li>
                            @endrole

                            @hasanyrole('User|Staff Desa')
                                <li class="nav-item">
                                    <a href="{{ url('surat') }}"
                                        class="nav-link @if (Request::is('surat/*') || Request::is('surat')) active @endif">
                                        <i class="fas fa-clipboard-list nav-icon"></i>
                                        <p>Surat</p>
                                    </a>
                                </li>
                            @endhasanyrole


                            @role('Staff Desa')
                                <li class="nav-item has-treeview @if (Request::is('user/*') || Request::is('user')) menu-open @endif">
                                    <a href="#" class="nav-link @if (Request::is('user/*') || Request::is('user')) active @endif">
                                        <i class="nav-icon fas fa-sliders-h"></i>
                                        <p>
                                            Settings
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav-item nav-treeview">
                                        <li class="nav-item ">
                                            <a href="{{ url('user') }}"
                                                class="nav-link @if (Request::is('user/*') || Request::is('user')) active @endif">
                                                <i class="fas fa-users-cog"></i>
                                                <p>User</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endrole
                        </ul>
                    </nav>
                </div>
            </aside>
            <div class="content-wrapper">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="{{ url('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ url('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ url('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ url('adminlte/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ url('adminlte/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ url('adminlte/plugins/jqvmap/maps/jquery.vmap.world.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ url('adminlte/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <!-- <script src="adminlte/plugins/moment/moment.min.js"></script> -->
    <script src="{{ url('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ url('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ url('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ url('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('adminlte/dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ url('adminlte/dist/js/pages/dashboard.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ url('adminlte/dist/js/demo.js') }}"></script><!-- ./wrapper -->
</body>

</html>
