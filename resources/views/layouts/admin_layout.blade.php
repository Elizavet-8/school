<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('/icons/circle-solid.png') }}" type="image/png">
    <title>Admin|@yield('title')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/admin_lte/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="/admin_lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/admin_lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="/admin_lte/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/admin_lte/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/admin_lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/admin_lte/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="/admin_lte/plugins/summernote/summernote-bs4.min.css">
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}" role="button">
                    Кабинет
                    <i class="fas fa-user ml-1"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" role="button" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                    Выход
                    <i class="fas fa-sign-out-alt ml-1"></i>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>

            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="/admin" class="brand-link">
            <img src="/admin_lte/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                 class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Админ-панель</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img style="height: 33px; object-fit: cover"
                         src="{{ Auth::user()->img_url ? Auth::user()->img_url : '/admin_lte/dist/img/user2-160x160.jpg' }}"
                         class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    @role('admin')
                    <li class="nav-item">
                        <a href="{{ route('home.admin') }}" class="nav-link">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>
                                Главная
                            </p>
                        </a>
                    </li>
                    @endrole
                    @role('admin|teacher')
                    <li class="nav-item">
                        <a href="{{ route('user.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            @if(auth()->user()->hasRole('teacher') && !auth()->user()->hasRole('admin'))
                            <p>
                                Мои ученики
                            </p>
                            @else
                            <p>
                                Пользователи
                            </p>
                            @endif
                        </a>
                    </li>
                    @endrole
                    {{-- <li class="nav-item">
                        <a href="{{ route('application.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-address-card"></i>
                            @if (DB::table('applications')->where('status', 'новая')->count() > 0)
                                <span
                                    class="badge badge-info right">{{ DB::table('applications')->where('status', 'новая')->count() }}</span>
                            @endif
                            <p>
                                Заявки
                            </p>
                        </a>
                    </li> --}}
                    @role('admin|teacher')
                    <li class="nav-item">
                        <a href="{{ route('course.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-book-open"></i>
                            <p>
                                Курсы
                            </p>
                        </a>
                    </li>
                    @endrole
                    @role('admin')
                    <li class="nav-item">
                        <a href="{{ route('school.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-school"></i>
                            <p>
                                Учебные заведения
                            </p>
                        </a>
                    </li>
                    @endrole
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div id="app" class="content-wrapper">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="/admin_lte/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="/admin_lte/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="/admin_lte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="/admin_lte/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="/admin_lte/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="/admin_lte/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="/admin_lte/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="/admin_lte/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="/admin_lte/plugins/moment/moment.min.js"></script>
<script src="/admin_lte/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="/admin_lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="/admin_lte/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="/admin_lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="/admin_lte/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/admin_lte/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/admin_lte/dist/js/pages/dashboard.js"></script>
<script src="/admin_lte/admin.js"></script>

<script src="{{mix('/js/app.js')}}"></script>
@stack('scripts')
</body>
</html>
