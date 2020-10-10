<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="{{ asset('../../assets/extra-libs/toastr/dist/build/toastr.min.css') }}" rel="stylesheet">

    {!! \Artesaos\SEOTools\Facades\SEOMeta::generate() !!}
    {!! \Artesaos\SEOTools\Facades\OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! \Artesaos\SEOTools\Facades\JsonLd::generate() !!}

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">

    <!--==== Google Fonts ====-->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500%7CSpectral:400,400i,500,600,700" rel="stylesheet">

    <!-- CSS Files -->

    <!--==== Bootstrap css file ====-->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!--==== Font-Awesome css file ====-->
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">

    <!--==== Animate CSS ====-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/animate/animate.min.css') }}">

    <!--==== Owl Carousel ====-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/owl-carousel/owl.carousel.min.css') }}">

    <!--==== Magnific Popup ====-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/magnific-popup/magnific-popup.css') }}">

    <!--==== Style css file ====-->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!--==== Custom css file ====-->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    <link rel="stylesheet" href="{{ asset('css/prism.css') }}">
    @yield('style')
</head>

<body>

<!-- Preloader -->
<div class="preloader">
    <div class="preload-img">
        <div class="spinnerBounce">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>
    </div>
</div>
<!-- End of Preloader -->

<!-- Nav Search Box -->
<div class="nav-search-box">
    <form action="{{ route('search') }}" method="POST">
        @csrf
        @method('POST')
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Ara ...">
            <span class="b-line"></span>
            <span class="b-line-under"></span>
            <div class="input-group-append">
                <button type="submit" class="btn">
                    <img src="{{ asset('assets/images/search-icon.svg') }}" alt="" class="img-fluid svg">
                </button>
            </div>
        </div>
    </form>
</div>
<!-- End of Nav Search Box -->

<!-- Header -->
<header class="header">
    <div class="header-fixed">
        <div class="container-fluid pl-120 pr-120 position-relative">
            <div class="row d-flex align-items-center">

                <div class="col-lg-3 col-md-4 col-6">
                    <!-- Logo -->
                    <div class="logo">
                        <a href="{{ route('index') }}"><img src="{{ asset('assets/images/logo.png') }}" alt="" class="img-fluid"></a>
                    </div>
                    <!-- End of Logo -->
                </div>

                <div class="col-lg-9 col-md-8 col-6 d-flex justify-content-end position-static">
                    <!-- Nav Menu -->
                    <div class="nav-menu-cover">
                        <ul class="nav nav-menu">
                            <li><a href="{{ route('index') }}">Anasayfa</a></li>
                            <li><a href="{{ route('about') }}">Hakkımda</a></li>
                            <li><a href="{{ route('categories') }}">Kategoriler</a></li>
                            <li><a href="{{ route('blogs') }}">Bloglar</a></li>
                            <li class="menu-item-has-children">
                                <a href="javascript:void(0)">
                                    @if(auth()->check())
                                        <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="rounded-circle" style="width: 31px!important; height: 31px!important;">
                                    @else
                                        <button class="rounded-circle btn btn-primary">Giriş Yap</button>
                                    @endif
                                </a>
                                <ul class="sub-menu">
                                    @if(auth()->check() == false)
                                        <li><a href="{{ route('login') }}">Giriş</a></li>
                                        <li><a href="{{ route('register') }}">Kaydol</a></li>
                                    @else
                                        <li><a href="{{ route('myprofile') }}">Kontrol Paneli</a></li>
                                        <li>
                                            <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> Çıkış </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- End of Nav Menu -->

                    <!-- Mobile Menu -->
                    <div class="mobile-menu-cover">
                        <ul class="nav mobile-nav-menu">
                            <li class="search-toggle-open">
                                <img src="{{ asset('assets/images/search-icon.svg') }}" alt="" class="img-fluid svg">
                            </li>
                            <li class="search-toggle-close hide">
                                <img src="{{ asset('assets/images/close.svg') }}" alt="" class="img-fluid">
                            </li>
                            <li class="nav-menu-toggle">
                                <img src="{{ asset('assets/images/menu-toggler.svg') }}" alt="" class="img-fluid svg">
                            </li>
                        </ul>
                    </div>
                    <!-- End of Mobile Menu -->
                </div>
            </div>
        </div>
    </div>
</header>
<!-- End of Header -->

@yield('content')

<!-- Newsletter -->
<section class="newsletter-cover">
    <!-- Overlay -->
    <div class="nl-bg-ol"></div>
    <div class="container">
        <div class="newsletter pt-80 pb-80">
            <!-- Section title -->
            <div class="section-title text-center">
                <h2>Bültenimize Abone Olun</h2>
            </div>
            <!-- End of Section title -->
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <!-- Newsletter Form -->
                    <form  action="{{ route('bulletion_post') }}" method="post" novalidate>
                        @csrf
                        @method('POST')
                        <div class="input-group">
                            <input type="text" name="email" class="form-control" placeholder="E-Posta Adresinizi Girin">
                            <div class="input-group-append">
                                <button class="btn btn-default" type="submit">Gönder</button>
                            </div>
                        </div>
                        {{--<p class="checkbox-cover d-flex justify-content-center">
                            <label> <a href="#"> Gizlilik Politikasını </a> okudum ve kabul ediyorum
                                <input type="checkbox">
                                <span class="checkmark"></span>
                            </label>
                        </p>--}}
                    </form>
                    <!-- End of Newsletter Form -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End of Newsletter -->

<!-- Footer -->
<footer class="footer-container d-flex align-items-center">
    <div class="container">
        <div class="row align-items-center footer">
            <div class="col-md-4 text-center text-md-left order-md-1 order-2">
                <div class="footer-social">
                    <a href="@if(isset(\App\User::whereEmail('emirgokkaya@hotmail.com')->get('facebook')[0]->facebook))
                            https://facebook.com/{{\App\User::whereEmail('emirgokkaya@hotmail.com')->get('facebook')[0]->facebook}}
                        @else https://facebook.com @endif"
                        target="_blank">
                        <i class="fa fa-facebook"></i>
                    </a>
                    <a href="@if(isset(\App\User::whereEmail('emirgokkaya@hotmail.com')->get('twitter')[0]->twitter))
                        https://twitter.com/{{\App\User::whereEmail('emirgokkaya@hotmail.com')->get('twitter')[0]->twitter}}
                    @else https://twitter.com @endif"
                       target="_blank">
                        <i class="fa fa-twitter"></i>
                    </a>
                    <a href="@if(isset(\App\User::whereEmail('emirgokkaya@hotmail.com')->get('youtube')[0]->youtube))
                        https://linkedin.com/{{\App\User::whereEmail('emirgokkaya@hotmail.com')->get('youtube')[0]->youtube}}
                    @else https://linkedin.com @endif"
                       target="_blank">
                        <i class="fa fa-youtube"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-4 d-flex justify-content-center order-md-2 order-1">
                <a href="{{ route('index') }}"><img src="{{ asset('assets/images/logo.png') }}" alt="" class="img-fluid"></a>
            </div>
            <div class="col-md-4 order-md-3 order-3">
                <div class="footer-cradit text-center text-md-right">
                    <p>© {{ date('Y') }} <a href="javascript:void(0)">Emir Gökkaya</a></p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- End of Footer -->

<!-- Back to Top Button -->
<div class="back-to-top d-flex align-items-center justify-content-center">
    <span><i class="fa fa-long-arrow-up"></i></span>
</div>
<!-- End of Back to Top Button -->

<!-- JS Files -->

<!-- ==== JQuery 1.12.1 js file ==== -->
<script src="{{ asset('assets/js/jquery-1.12.1.min.js') }}"></script>

<!-- ==== Bootstrap js file ==== -->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

<!-- ==== Owl Carousel ==== -->
<script src="{{ asset('assets/plugins/owl-carousel/owl.carousel.min.js') }}"></script>

<!-- ==== Magnific Popup ==== -->
<script src="{{ asset('assets/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

<!-- ==== Script js file ==== -->
<script src="{{ asset('assets/js/scripts.js') }}"></script>

<!-- ==== Custom js file ==== -->
<script src="{{ asset('assets/js/custom.js') }}"></script>

<script src="{{ asset('js/prism.js') }}"></script>

<script src="{{ asset('../../assets/extra-libs/toastr/dist/build/toastr.min.js') }}"></script>
<script src="{{ asset('../../assets/extra-libs/toastr/toastr-init.js') }}"></script>

<script>
    @if(Session::has('message'))
    toastr.{{Session::get('status')}}('{{ Session::get('message') }}');
    @endif

    @if ($errors->any())
    @foreach ($errors->all() as $error)
    toastr.error('{{$error}}');
    @endforeach
    @endif
</script>

@yield('javascript')

</body>
</html>
