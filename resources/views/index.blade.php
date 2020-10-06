@extends('layouts.master')

@section('content')

    @if(count($sliders) != 0)
        <!-- Banner -->
        <div class="banner-slider-cover d-flex align-items-center">
            <div class="container">
                <div class="banner-slider owl-carousel">


                @forelse($sliders as $slider)
                    <!-- Banner Slide -->
                        <div class="banner-slide">
                            <div class="row align-items-center">
                                <div class="col-md-6 order-2 order-md-1">
                                    <!-- Banner Text -->
                                    <div class="banner-slide-text">
                                        <p class="category"><a href="javascript:void(0)">{{ $slider->user->name }}</a></p>
                                        <h1>{{ $slider->title }}</h1>
                                        <p class="desc">{{ $slider->description }}</p>
                                    </div>
                                    <!-- End of Banner Text -->
                                </div>
                                <div class="col-md-6 order-1 order-md-2">
                                    <!-- Banner Image -->
                                    <div class="banner-slide-image">
                                        <img src="{{ $slider->resize_image }}" style="width: 528px!important; height: 528px!important;" alt="" class="img-fluid">
                                    </div>
                                    <!-- End of Banner Image -->
                                </div>
                            </div>
                        </div>
                        <!-- End of Banner Slide -->
                    @empty
                    @endforelse

                </div>

                <!-- Banner Dots Slider -->
                <div class="banner-slider-dots owl-carousel"></div>
            </div>
            <!-- End of Banner Dots Slider -->
        </div>
        <!-- End of Banner -->
    @endif

    <!-- Trending Posts-->
    <section class="pt-120 pb-10">
        <div class="container">
            <!-- Section Title -->
            @if(isset($most_like_post) && count($most_like_post) != 0)
                <div class="section-title text-center">
                    <h2>Çok Beğenilenler</h2>
                </div>
                <!-- Section Title -->
            @endif

            <div class="row">
                @if(isset($most_like_post))
                    @forelse($most_like_post as $most_like)
                        <div class="col-lg-6 order-lg-1">
                            <!-- Post -->
                            <div class="post-default post-has-no-thumb">
                                <div class="post-data">
                                    <!-- Category -->
                                    <div class="cats"><a href="{{ route('category_blogs', ['slug' => $most_like->category->slug]) }}">{{ $most_like->category->name }}</a></div>
                                    <!-- Title -->
                                    <div class="title">
                                        <h2><a href="{{ route('blog_detail', ['slug' => $most_like->slug]) }}">{{ $most_like->title }}</a></h2>
                                    </div>
                                    <!-- Post Meta -->
                                    <ul class="nav meta align-items-center">
                                        <li class="meta-author">
                                            <img src="{{ $most_like->user->avatar }}" alt="" class="img-fluid">
                                            <a href="{{ route('user_blogs', ['name' => $most_like->user->name, 'id' => $most_like->user->id]) }}">{{ $most_like->user->name }}</a>
                                        </li>
                                        <li class="meta-date"><p>{{ date('j F Y')}}</p></li>
                                        <li class="meta-comments"><a href="{{ route('blog_detail', ['slug' => $most_like->slug]) }}"><i class="fa fa-comment"></i> {{ $most_like->comments->count() }}</a></li>
                                        <li>
                                            <a href="javascript:void(0)" onclick="likeBlog({{ $most_like->id }})">
                                                <i class="fa fa-heart mr-2 @forelse($most_like->likes as $like) @if(!empty(auth()->user())) @if($like->user_id === auth()->user()->id) text-danger @endif @endif @empty @endforelse"></i>{{ $most_like->likes->count() }}
                                            </a>

                                            <form id="likeBlog-{{$most_like->id}}" action="{{ route('add-like', ['id' => $most_like->id]) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('POST')
                                            </form>
                                        </li>
                                    </ul>
                                    <!-- Post Desc -->
                                    <div class="desc">
                                        <p>
                                            {{ \Illuminate\Support\Str::limit($most_like->summary, 300) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- End of Post -->
                        </div>
                    @empty
                    @endforelse
                @endif
            </div>
        </div>
    </section>
    <!-- End of Trending Posts-->

    <!-- post with sidebar -->
    <div class="container pt-40 pb-90">
        <div class="row">
            <div class="col-lg-8">
                <!-- Most Viewed Post -->
                <section class="pt-40 pb-10 most-viewed">
                    <!-- Section title -->
                    @if(isset($news) && count($news) != 0)
                        <div class="section-title">
                            <h2>Güncel Bloglar</h2>
                        </div>
                @endif
                <!-- End of Section title -->
                    <div class="post-blog-list">
                        <div class="row">
                            {{--@if(!empty($lastNew))
                            <div class="col-sm-12">
                                <!-- Post -->
                                <div class="post-default post-has-front-title">
                                    <div class="post-thumb">
                                        <a href="{{ route('blog_detail', ['slug' => $lastNew->slug]) }}"> <img src="{{ $lastNew->resize_image }}" style="width: 960px!important; height: 500px!important;" alt="" class="img-fluid"> </a>
                                    </div>
                                    <div class="post-data">
                                        <!-- Category -->
                                        <div class="cats"><a href="{{ route('category_blogs', ['slug' => $lastNew->category->slug]) }}">{{ \Illuminate\Support\Str::limit($lastNew->category->name, 20) }}</a></div>
                                        <!-- Title -->
                                        <div class="title">
                                            <h2><a href="{{ route('blog_detail', ['slug' => $lastNew->slug]) }}">{{ \Illuminate\Support\Str::limit($lastNew->title, 50) }}</a></h2>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Post -->
                            </div>
                            @endif--}}

                            @if(!empty($news))
                                @forelse($news as $new)
                                    <div class="col-sm-6">
                                        <!-- Post -->
                                        <div class="post-default">
                                            <div class="post-thumb">
                                                <a href="{{ route('blog_detail', ['slug' => $new->slug]) }}"> <img src="{{ $new->resize_image }}" alt="" style="width: 400px!important; height: 200px!important;" class="img-fluid"> </a>
                                            </div>
                                            <div class="post-data">
                                                <!-- Category -->
                                                <div class="cats"><a href="{{ route('category_blogs', ['slug' => $new->category->slug]) }}">{{ \Illuminate\Support\Str::limit($new->category->name, 20) }}</a></div>
                                                <!-- Title -->
                                                <div class="title">
                                                    <h2><a href="{{ route('blog_detail', ['slug' => $new->slug]) }}">{{ \Illuminate\Support\Str::limit($new->title, 50) }}</a></h2>
                                                </div>
                                                <!-- Post Desc -->
                                                <div class="desc">
                                                    <p>
                                                        {{ \Illuminate\Support\Str::limit($new->summary, 200) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End of Post -->
                                    </div>
                                @empty
                                @endforelse
                            @endif

                        </div>
                    </div>
                </section>
                <!-- End of Most Viewed Post -->

                {{--<!-- 728 ad -->
                <div class="pt-40 pb-40 biz-ad">
                    <a href="#"><img src="{{ asset('assets/images/ad-728.png') }}" alt="" class="img-fluid"></a>
                </div>
                <!-- End of 728 ad -->--}}

            </div>
            <div class="col-lg-4">
                <div class="pt-88">
                    <div class="my-sidebar">
                        {{-- <!-- Ad Widget -->
                         <div class="widget widget-ad">
                             <!-- Widget Content -->
                             <div class="widget-content">
                                 <a href="#">
                                     <img src="{{ asset('assets/images/sidebar/ad.jpg') }}" alt="" class="img-fluid">
                                 </a>
                             </div>
                             <!-- End of Widget Content -->
                         </div>
                         <!-- End of Ad Widget -->--}}

                        @if(isset($most_comments_news) && count($most_comments_news) != 0)

                        <!-- Most Commented Post Widget -->
                            <div class="widget widget-most-commented-post">
                                <!-- Widget Title -->
                                <h4 class="widget-title">
                                    Çok yorum yapılanlar
                                </h4>
                                <!-- End of Widget Title -->

                                <!-- Widget Content -->
                                <div class="widget-content">
                                    <!-- Post Carousel -->
                                    <div class="wmcp-cover owl-carousel" data-owl-mouse-drag="true" data-owl-dots="true" data-owl-margin="20">
                                    @if(!empty($most_comments_news))
                                        @forelse($most_comments_news as $news)
                                            <!-- Carousel Item -->
                                                <div class="wmcp-item">
                                                    <!-- Single Post -->
                                                    <div class="wmc-post">
                                                        <a href="{{ route('blog_detail', ['slug' => $news->slug]) }}">
                                                            <img src="{{ $news->image }}" alt="" class="img-fluid">
                                                        </a>
                                                        <div class="wmc-post-title">
                                                            <h6> <a href="{{ route('blog_detail', ['slug' => $news->slug]) }}"> {{ \Illuminate\Support\Str::limit($news->title, 20) }} </a></h6>
                                                        </div>
                                                    </div>
                                                    <!-- End of Single Post -->

                                                    {{--  <div class="wmc-post">
                                                          <a href="blog-details.html">
                                                              <img src="{{ $news->image }}" alt="" class="img-fluid">
                                                          </a>
                                                          <div class="wmc-post-title">
                                                              <h6> <a href="blog-details.html"> Understanding The Background Of Fashion </a></h6>
                                                          </div>
                                                      </div>--}}{{--
                                                      <!-- End of Single Post -->--}}
                                                </div>
                                            @empty
                                                Henüz içeriklere yorum yapılmamış
                                        @endforelse
                                    @endif
                                    <!-- End of Carousel Item -->
                                    </div>
                                    <!-- End of Post Carousel -->

                                </div>
                                <!-- End of Widget Content -->
                            </div>
                            <!-- End of Most Commented Post Widget -->
                        @endif


                        @if(isset($categories) && count($categories) != 0)
                        <!-- Tags Cloud Widget -->
                            <div class="widget widget-tag-cloud">
                                <!-- Widget Title -->
                                <h4 class="widget-title">
                                    Kategoriler
                                </h4>
                                <!-- End of Widget Title -->

                                <!-- Widget Content -->
                                <div class="widget-content tagcloud">
                                    @if(!empty($categories))
                                        @forelse($categories as $category)
                                            <a href="{{ route('category_blogs', ['slug' => $category->slug]) }}">{{ \Illuminate\Support\Str::limit($category->name, 20) }}</a>
                                        @empty
                                        @endforelse
                                    @endif
                                </div>
                                <!-- End of Widget Content -->
                            </div>
                            <!-- End of Tags Cloud Widget -->
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end of post with sidebar -->


@endsection

@section('javascript')
    <script>
        function likeBlog(id) {
            event.preventDefault();
            document.getElementById('likeBlog-' + id).submit();
        }
    </script>
@endsection
