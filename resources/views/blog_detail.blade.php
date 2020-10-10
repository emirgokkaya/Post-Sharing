@extends('layouts.master')

@section('content')
    <!-- Page title -->
    <div class="page-title">
        <div class="container">
            <h2>Blog</h2>
            <ul class="nav">
                <li><a href="{{ route('index') }}">Anasayfa</a></li>
                <li><a href="{{ route('blogs') }}">Bloglar</a></li>
                <li>{{ $blog->title }}</li>
            </ul>
        </div>
    </div>
    <!-- End of Page title -->

    <div class="container pb-120">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="post-details-cover post-has-full-width-image">
                    <!-- Post Thumbnail -->
                    <div class="post-thumb-cover">
                        <div class="post-thumb">
                            <img src="{{ $blog->image }}" style="width: 1920px!important; height: 1000px!important;" alt="" class="img-fluid">
                        </div>
                        <!-- Post Meta Info -->
                        <div class="post-meta-info">
                            <!-- Category -->
                            <p class="cats">
                                <a href="{{ route('category_blogs', ['slug' => $blog->category->slug]) }}">{{ $blog->category->name }}</a>
                            </p>

                            <!-- Title -->
                            <div class="title">
                                <h2>{{ $blog->title }}</h2>
                            </div>

                            <!-- Meta -->
                            <ul class="nav meta align-items-center">
                                <li class="meta-author">
                                    <img src="{{ $blog->user->avatar }}" alt="" class="img-fluid">
                                    <a href="{{ route('user_blogs', ['name' => $blog->user->name, 'id' => $blog->user->id]) }}">{{ $blog->user->name }}</a>
                                </li>
                                <li class="meta-date"><a href="javascript:void(0)">{{ date('j F Y') }}</a></li>
                                <li class="meta-comments"><a href="#commentArea"><i class="fa fa-comment"></i> {{ count($comments) }}</a></li>
                                <li><a href="javascript:void(0)" onclick="likeButton({{ $blog->id }})"><i class="fa fa-heart mr-2 @if($css === 1) text-danger @endif"></i></a> {{ $likes }} </li>

                                <form id="like-blog-{{$blog->id}}" action="{{ route('add-like', ['id' => $blog->id]) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('POST')
                                </form>

                            </ul>
                        </div>
                        <!-- End of Post Meta Info -->
                    </div>
                    <!-- End oF Post Thumbnail -->

                    <!-- Post Content -->
                    <div class="post-content-cover my-drop-cap">
                        <p>
                            {{ $blog->summary }}
                        </p>

                        <div class="post-my-gallery-images">
                            <h3>
                                <hr>
                            </h3>
                        </div>

                        <p>
                            {!! $blog->content !!}
                        </p>
                    </div>
                    <!-- End of Post Content -->

                    <!-- Tags -->
                    <div class="post-all-tags">
                        <a href="{{ route('category_blogs', ['slug' => $blog->category->slug]) }}">{{ $blog->category->name }}</a>
                    </div>
                    <!-- End of Tags -->

                    <!-- Author Box -->
                    <div class="post-about-author-box">
                        <div class="author-avatar">
                            <img src="{{ $blog->user->avatar }}" alt="" class="img-fluid rounded-circle">
                        </div>
                        <div class="author-desc">
                            <h5> <a href="{{ route('user_blogs', ['name' => $blog->user->name, 'id' => $blog->user->id]) }}">{{ $blog->user->name }}</a>  </h5>
                            @if($blog->user->description != null)
                            <div class="description">
                                {{ $blog->user->description }}
                            </div>
                            @endif
                            @if($blog->user->facebook || $blog->user->twitter || $blog->user->youtube)
                                <div class="social-icons">
                                    @if($blog->user->facebook)<a href="https://facebook.com/{{ $blog->user->facebook }}"><i class="fa fa-facebook"></i></a>@endif
                                    @if($blog->user->twitter)<a href="https://twitter.com/{{ $blog->user->twitter }}"><i class="fa fa-twitter"></i></a>@endif
                                    @if($blog->user->youtube)<a href="https://youtube.com/{{ $blog->user->youtube }}"><i class="fa fa-youtube"></i></a>@endif
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- End of Author Box -->

                    <!-- Comments -->
                    <button id="commentArea" class="btn btn-comment" type="button" data-toggle="collapse" data-target="#commentToggle" aria-expanded="false" aria-controls="commentToggle">
                        Yorumlar (<span id="counterComment">{{ count($comments) }}</span>)
                    </button>




                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (\Session::has('message'))
                        <div class="alert alert-{{ \Session::get('status') }}">
                            <ul>
                                <li>{!! \Session::get('message') !!}</li>
                            </ul>
                        </div>
                    @endif




                    <div class="collapse show" id="commentToggle">
                        <ul class="post-all-comments" id="blogDetailAndComment">
                            {{--<li class="single-comment-wrapper">
                                <!-- Single Comment -->
                                <div class="single-post-comment">
                                    <!-- Author Image -->
                                    <div class="comment-author-image">
                                        <img src="{{ asset('assets/images/blog/post/author-1.jpg') }}" alt="" class="img-fluid">
                                    </div>
                                    <!-- Comment Content -->
                                    <div class="comment-content">
                                        <div class="comment-author-name">
                                            <h6>Don Norman</h6> <span> 5 Jan 2019 at 6:40 pm </span>
                                        </div>
                                        <p>On recommend tolerably my belonging or am. Mutual has cannot beauty indeed now back sussex merely you. It possible no husbands jennings offended.</p>
                                        <a href="#" class="reply-btn">Reply</a>
                                    </div>
                                </div>
                                <!-- End of Single Comment -->
                                <ul class="children">
                                    <li class="single-comment-wrapper">
                                        <!-- Single Comment -->
                                        <div class="single-post-comment">
                                            <!-- Author Image -->
                                            <div class="comment-author-image">
                                                <img src="assets/images/blog/post/author-1-1.jpg" alt="" class="img-fluid">
                                            </div>
                                            <!-- Comment Content -->
                                            <div class="comment-content">
                                                <div class="comment-author-name">
                                                    <h6>Helen Sharp</h6> <span> 5 Jan 2019 at 6:58 pm </span>
                                                </div>
                                                <p>On recommend tolerably my belonging or am. Mutual has cannot back beauty indeed now back sussex merely you. </p>
                                                <a href="#" class="reply-btn">Reply</a>
                                            </div>
                                        </div>
                                        <!-- End of Single Comment -->
                                    </li>
                                </ul>
                            </li>--}}
                            @forelse($comments as $comment)
                            <li class="single-comment-wrapper">
                                <!-- Single Comment -->
                                <div class="single-post-comment">
                                    <!-- Author Image -->
                                    <div class="comment-author-image">
                                        <img src="{{ $comment->user->avatar }}" alt="{{ $comment->user->name }}" class="img-fluid rounded-circle" style="width: 100px!important; height: 100px!important;">
                                    </div>
                                    <!-- Comment Content -->
                                    <div class="comment-content">
                                        <div class="comment-author-name">
                                            <h6>{{ $comment->user->name }}@if($blog->user->email === $comment->user->email) <span>(Yazar)</span> @endif</h6> <span> {{ date('j F Y', strtotime($comment->created_at)) }} at {{ date('h:i A', strtotime($comment->created_at)) }} </span>
                                        </div>
                                        <p>{{ $comment->comment }}</p>
                                        @if(auth()->user())
                                            {{--@if($comment->user->email === auth()->user()->email)<a href="#" class="reply-btn btn btn-warning"><i class="fa fa-edit"></i></a>@endif--}}
                                            @if($comment->user->email === auth()->user()->email)<a href="javascript:void(0)" onclick="deleteComment({{ $comment->id }})" class="reply-btn btn btn-danger"><i class="fa fa-trash"></i></a>@endif
                                            <form id="delete-comment-{{$comment->id}}" action="{{ route('delete_comment', ['news_slug' => $blog->slug, 'id' => $comment->id]) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endif
                                    </div>
                                </div>
                                <!-- End of Single Comment -->
                            </li>
                            @empty
                                <h3 class="text-danger text-center" id="nothingComment">Henüz bir yorum yapılmamış ilk yorumu siz yapın :)</h3>
                            @endforelse
                        </ul>
                    </div>
                    <!-- End of Comments -->

                    @if(auth()->user())
                    <!-- Comment Form -->
                    <div class="post-comment-form-cover">
                        <h3>Yorum Yazın</h3>
                        <form class="comment-form" method="POST" action="{{ route('comment-post', ['news' => $blog->id]) }}">
                            @csrf
                            @method('POST')
                            <div class="row">
                                <div class="col-md-12">
                                    <textarea name="comment" class="form-control" placeholder="Yorumunuzu yazın ..." id="commentArea"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-primary" type="submit" id="submitButton" name="submitButton">Gönder </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @else
                            Yorum yazabilmek için öncelikle giriş yapmanız gerekmetedir <a href="{{ route('login') }}" class="btn btn-danger" style="border-radius: 12px">Giriş</a>
                    @endif
                    <!-- End of Comment Form -->
                </div>
            </div>
        </div>
    </div>

@endsection

<style>
    html {
        scroll-behavior: smooth;
    }
</style>


@section('javascript')
    <script src="{{ asset('../../assets/extra-libs/toastr/dist/build/toastr.min.js') }}"></script>
    <script src="{{ asset('../../assets/extra-libs/toastr/toastr-init.js') }}"></script>

    <script>
        /*$(function (news) {
            $('form').on('submit', function (e) {

                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: '/comment/' + {{--{{ $blog->id }}--}},
                    data: $('form').serialize(),
                    success: function (response) {
                        console.log(response["comment"])
                        $('#blogDetailAndComment').prepend(
                            "<li class='single-comment-wrapper'>" +
                            "<div class='single-post-comment'>" +
                            "<div class='comment-author-image'>" +
                            "<img src='" + response["comment"].user.avatar + "'  class='img-fluid rounded-circle' style='width: 100px!important; height: 100px!important;'>" +
                            "</div>" +
                            "<div class='comment-content'>" +
                            "<div class='comment-author-name'>" +
                            "<h6>" + response["comment"].user.name + (response["comment"].user.id === response["comment"].news.user_id ? '<small> (Yazar)</small>': '') + "</h6> <span>" + response["comment"].created_at + "</span>" +
                            "</div>" +
                            "<p>" + response["comment"].comment + "</p>" +
                                {{--@if(\Illuminate\Support\Facades\Auth::check() == true)--}}
                                (response["comment"].user.email === response["user"].email ? "<a href='#' class='reply-btn btn btn-warning'><i class='fa fa-edit'></i></a>&nbsp;": '') +
                                (response["comment"].user.email === response["user"].email ? "<a href='#' class='reply-btn btn btn-danger'><i class='fa fa-trash'></i></a>": '') +
                                {{--@endif--}}
                                    "</div>" +
                                "</div>" +
                                "</li>");

                        $('#nothingComment').remove();

                        var result = parseInt($('#counterComment').html());
                        result += 1;
                        $('#counterComment').empty();
                        $('#counterComment').append(result);

                        /!*location.reload();*!/
                        $('textarea#commentArea').val("");
                        toastr.success("Yorum kaydedildi")
                    },
                    error: function (response) {
                        alert('error');
                    }
                });

            });

        });*/

        function likeButton(id) {
            event.preventDefault();
            document.getElementById('like-blog-'+id).submit();
        }

        function deleteComment(id) {
            event.preventDefault();
            document.getElementById('delete-comment-'+id).submit();
        }
    </script>
    </script>
@endsection

@section('style')
    <link href="{{ asset('../../assets/extra-libs/toastr/dist/build/toastr.min.css') }}" rel="stylesheet">
@endsection
