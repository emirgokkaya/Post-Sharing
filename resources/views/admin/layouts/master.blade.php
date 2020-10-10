<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    @yield('meta')

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('../../assets/images/favicon.png') }}">
    <title>AdminBite admin Template - The Ultimate Multipurpose admin template</title>
    <!-- Custom CSS -->
    <link href="{{ asset('../../assets/extra-libs/c3/c3.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('../../dist/css/style.min.css') }}" rel="stylesheet">
    <link href="{{ asset('../../assets/extra-libs/toastr/dist/build/toastr.min.css') }}" rel="stylesheet">
    @yield('stylesheet')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>

<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>

<div id="main-wrapper">
    <header class="topbar">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
            <div class="navbar-header">
                <!-- This is for the sidebar toggle which is visible on mobile only -->
                <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                    <i class="ti-menu ti-close"></i>
                </a>
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <a class="navbar-brand" href="@if(auth()->user()->role === "admin") {{ route('dashboard') }} @elseif(auth()->user()->role === "editor") {{ route('myprofile') }} @endif">
                    <!-- Logo icon -->
                    <b class="logo-icon">
                        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                        <!-- Dark Logo icon -->
                        <img src="{{ asset('../../assets/images/logo-icon.png') }}" alt="homepage" class="dark-logo" />
                        <!-- Light Logo icon -->
                        <img src="{{ asset('../../assets/images/logo-light-icon.png') }}" alt="homepage" class="light-logo" />
                    </b>
                    <!--End Logo icon -->
                    <!-- Logo text -->
                    <span class="logo-text">
                            <!-- dark Logo text -->
                            <img src="{{ asset('../../assets/images/logo-text.png') }}" alt="homepage" class="dark-logo" />
                        <!-- Light Logo text -->
                            <img src="{{ asset('../../assets/images/logo-light-text.png') }}" class="light-logo" alt="homepage" />
                        </span>
                </a>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Toggle which is visible on mobile only -->
                <!-- ============================================================== -->
                <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent"
                   aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="ti-more"></i>
                </a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <div class="navbar-collapse collapse" id="navbarSupportedContent">
                <!-- ============================================================== -->
                <!-- toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav float-left mr-auto">

                </ul>
                <!-- ============================================================== -->
                <!-- Right side toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav float-right">
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false">
                            <img src="{{ auth()->user()->avatar }}" alt="user" class="rounded-circle" width="31" height="31">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <span class="with-arrow">
                                    <span class="bg-primary"></span>
                                </span>
                            <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                                <div class="">
                                    <img src="{{ auth()->user()->avatar }}" alt="user" class="img-circle" width="60">
                                </div>
                                <div class="m-l-10">
                                    <h4 class="m-b-0">{{ auth()->user()->name }}</h4>
                                    <p class=" m-b-0">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                            <a class="dropdown-item" href="{{ route('myprofile') }}">
                                <i class="ti-user m-r-5 m-l-5"></i> Profilim</a>

                            {{-- Logout button --}}
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item" href="javascript:void(0)" type="submit">
                                    <i class="fa fa-power-off m-r-5 m-l-5"></i>Logout
                                </button>
                            </form>
                            {{-- End Logout button --}}


                        </div>
                    </li>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                </ul>
            </div>
        </nav>
    </header>
    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    @if(auth()->user()->role === "admin")
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <!-- User Profile-->
                        <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i> <span class="hide-menu">Menu</span></li>

                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark" href="{{ route('index') }}" target="_blank" aria-expanded="false">
                                <i class="icon-Home-2"></i>
                                <span class="hide-menu">Web Sitesi </span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark" href="{{ route('dashboard') }}" aria-expanded="false">
                                <i class="icon-Car-Wheel"></i>
                                <span class="hide-menu">Kontrol Paneli </span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark" href="{{ route('users') }}" aria-expanded="false">
                                <i class="icon-User"></i>
                                <span class="hide-menu">Kullanıcılar </span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark" href="{{ route('sliders') }}" aria-expanded="false">
                                <i class="icon-Video-Photographer"></i>
                                <span class="hide-menu">Slayt</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark" href="{{ route('category') }}" aria-expanded="false">
                                <i class="icon-Bulleted-List"></i>
                                <span class="hide-menu">Kategoriler</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark" href="{{ route('news') }}" aria-expanded="false">
                                <i class="icon-Newspaper-2"></i>
                                <span class="hide-menu">Haberler</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark" href="{{ route('comments') }}" aria-expanded="false">
                                <i class="icon-Bookmark"></i>
                                <span class="hide-menu">Yorumlar</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
    @endif
    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        @yield('content')
        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer text-center">
            All Rights Reserved by Post-in. Designed and Developed by
            <a href="{{ env("APP_URL") }}">emirgokkaya</a>.
        </footer>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{ asset('../../assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('../../assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
<script src="{{ asset('../../assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- apps -->
<script src="{{ asset('../../dist/js/app.min.js') }}"></script>
<!-- Theme settings -->
<script src="{{ asset('../../dist/js/app.init.horizontal-fullwidth.js') }}"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{ asset('../../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
<script src="{{ asset('../../assets/extra-libs/sparkline/sparkline.js') }}"></script>
<!--Wave Effects -->
<script src="{{ asset('../../dist/js/waves.js') }}"></script>
<!--Menu sidebar -->
<script src="{{ asset('../../dist/js/sidebarmenu.js') }}"></script>
<!--Custom JavaScript -->
<script src="{{ asset('../../dist/js/custom.min.js') }}"></script>
<!--This page JavaScript -->
<!--c3 JavaScript -->
<script src="{{ asset('../../assets/extra-libs/c3/d3.min.js') }}"></script>
<script src="{{ asset('../../assets/extra-libs/c3/c3.min.js') }}"></script>
<script src="{{ asset('../../dist/js/pages/dashboards/dashboard3.js') }}"></script>
{{-- Toastr --}}
<script src="{{ asset('../../assets/extra-libs/toastr/dist/build/toastr.min.js') }}"></script>
<script src="{{ asset('../../assets/extra-libs/toastr/toastr-init.js') }}"></script>
@yield('javascript')
</body>

</html>
