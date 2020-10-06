@extends('layouts.master')

@section('content')
    <!-- Page title -->
    <div class="page-title">
        <div class="container">
            <h2>Hakkımda</h2>
            <ul class="nav">
                <li><a href="{{ route('index') }}">Anasayfa</a></li>
                <li>Hakkımda</li>
            </ul>
        </div>
    </div>
    <!-- End of Page title -->

    <div class="container pt-120 pb-90">
        <div class="row">
            <div class="col-md-12">
                <div class="page-thumb">
                    <img src="assets/images/blog/page-cover.jpg" alt="" class="img-fluid">
                </div>
                <div class="col-md-10 offset-md-1">
                    <div class="page-text">
                        <div class="page-primary-text pb-60">
                            <div class="page-para-title h2">Emir Gökkaya</div>
                            <p>Selam! Türkiye'nin İstanbul şehrinde yaşayan bir Bilgisayar Mühendisiyim.
                                Şu anda İstanbul'da serbest çalışıyorum. Şirketlerin kullanıcı merkezli tasarım yoluyla unutulmaz
                                deneyimler yaratmalarına yardımcı oluyorum. Marka geliştirmeyi seven deneyimli bir Web geliştiricisiyim. Benim değerim mantıksal ve duygusal kavramların kesişmesi.
                                Çalışmaya 2 yıl önce başladım ve o zamandan beri back-end olsun, front-end olsun birçok web sitesi için geliştirmeler yaptım.</p>
                        </div>

                        <div class="page-primary-text pb-40">
                            <div class="page-para-title h3">Deneyimlerim</div>
                            <ul>
                                <li>
                                    PHP(MVC)
                                </li>
                                <li>Laravel Framework</li>
                                <li>Vue JS</li>
                                <li>Unity 3D</li>
                                <li>Python</li>
                                <li>HTML, CSS, Bootstrap</li>
                            </ul>
                        </div>

                        <div class="page-image-gallery">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="page-gallery-single">
                                        <img src="{{ asset('assets/images/page/1.jpg') }}" alt="" class="img-fluid">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="page-gallery-single">
                                        <img src="{{ asset('assets/images/page/2.jpg') }}" alt="" class="img-fluid">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="page-gallery-single">
                                        <img src="{{ asset('assets/images/page/3.jpg') }}" alt="" class="img-fluid">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="page-gallery-single">
                                        <img src="{{ asset('assets/images/page/4.jpg') }}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
