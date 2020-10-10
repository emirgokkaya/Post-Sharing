@extends('admin.layouts.master')
@section('content')
    <div id="main-wrapper">
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
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <center class="m-t-30"> <img src="{{ auth()->user()->avatar }}" class="rounded-circle" width="150" height="150" />
                                    <h4 class="card-title m-t-10">{{ auth()->user()->name }}
                                        <small class="text-secondary">
                                            @if(auth()->user()->role === "admin") (Admin)
                                            @elseif(auth()->user()->role === "editor") (Editör)
                                            @endif
                                        </small>
                                    </h4>
                                    <h6 class="card-subtitle">@if(auth()->user()->job != null) {{ auth()->user()->job }} @else Belirtilmemiş @endif</h6>
                                    <div class="row text-center justify-content-md-center">
                                        <div class="col-4"><p  class="link"><i class="icon-people"></i> <font class="font-medium">{{ $my_news_comments_count }} <small>(Yapılan Yorumlar)</small></font></p></div>
                                        <div class="col-4"><p class="link"><i class="icon-picture"></i> <font class="font-medium">{{ $my_comments_count }} <small>(Toplam Yorumum)</small></font></p></div>
                                    </div>
                                    <div class="row text-center justify-content-md-center">
                                        <div class="col-4"><p class="link"><i class="icon-picture"></i> <font class="font-medium">{{ $my_news_likes_count }} <small>(Yapılan Beğeniler)</small></font></p></div>
                                        <div class="col-4"><p class="link"><i class="icon-picture"></i> <font class="font-medium">{{ $my_likes_count }} <small>(Toplam Beğenilerim)</small></font></p></div>
                                    </div>
                                </center>
                            </div>
                            <div>
                                <hr> </div>
                            <div class="card-body"> <small class="text-muted">E-Posta adresi </small>
                                <h6>{{ auth()->user()->email }}</h6> <small class="text-muted p-t-30 db">Telefon</small>
                                <h6>@if(auth()->user()->phone != null) +90 {{ auth()->user()->phone }} @else Belirtilmemiş @endif</h6> <small class="text-muted p-t-30 db">Adres</small>
                                <h6>@if(auth()->user()->address != null) {{ auth()->user()->address }} @else Belirtilmemiş @endif</h6>

                                @if(auth()->user()->facebook != null || auth()->user()->twitter != null || auth()->user()->youtube != null)
                                    <small class="text-muted p-t-30 db">Sosyal Hesaplar</small>
                                    <br/>
                                @else
                                    <small class="text-muted p-t-30 db">Sosyal Hesaplar</small>
                                    <br/>
                                    Belirtilmemiş
                                @endif
                                @if(auth()->user()->facebook != null)
                                    <a href="https://facebook.com/{{ auth()->user()->facebook }}" target="_blank" class="btn btn-circle btn-secondary">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                @endif
                                @if(auth()->user()->twitter != null)
                                    <a href="https://twitter.com/{{ auth()->user()->twitter }}" target="_blank" class="btn btn-circle btn-secondary">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                @endif
                                @if(auth()->user()->youtube != null)
                                    <a href="https://youtube.com/{{ auth()->user()->youtube }}" target="_blank" class="btn btn-circle btn-secondary">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <!-- Tabs -->
                            <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-timeline-tab" data-toggle="pill" href="#current-month" role="tab" aria-controls="pills-timeline" aria-selected="true">Zaman Çizelgesi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#previous-month" role="tab" aria-controls="pills-setting" aria-selected="false">Ayarlar</a>
                                </li>
                            </ul>
                            <!-- Tabs -->
                            <div class="tab-content" id="pills-tabContent2">
                                <div class="tab-pane fade show active" id="current-month" role="tabpanel" aria-labelledby="pills-timeline-tab">
                                    <div class="card-title">
                                        <div class="row mt-5">
                                            <div class="col-6 offset-3 text-right">
                                                <a href="{{ route('mynewpost') }}" class="btn btn-info btn-block"><i class="fa fa-plus"></i></a>
                                            </div>
                                            @if($news->count() != 0)
                                            <form action="{{ route('myallpostdelete') }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Tüm içeriğini silmek istediğinden emin misin ?')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                            </form>
                                            @endif
                                        </div>
                                        <div class="row mt-5">
                                            <div class="col-6 offset-3 text-right">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="profiletimeline m-t-0">
                                            @forelse($news as $new)
                                            <div class="sl-item">
                                                <div class="sl-left"> <img src="{{ auth()->user()->avatar }}" alt="user" class="rounded-circle" /> </div>
                                                <div class="sl-right">
                                                    <div> <a href="{{ route('user_blogs', ['name' => auth()->user()->name, 'id' => auth()->user()->id]) }}" class="link">{{ auth()->user()->name }}</a> <span class="sl-date">{{ $new->created_at->diffForHumans() }}</span>
                                                        <div class="m-t-20 row">
                                                            <div class="col-md-3 col-xs-12">
                                                                <img src="{{ $new->image }}" alt="user" class="img-fluid rounded"/>
                                                            </div>
                                                            <div class="col-md-9 col-xs-12">
                                                                <h4>{{ $new->title }}</h4>
                                                                <p>{{ \Illuminate\Support\Str::limit($new->summary, 1300) }}</p>

                                                                @if($new->block === 1)
                                                                        <a href="{{ route('blog_detail', ['slug' => $new->slug]) }}" class="btn btn-primary" target="_blank"> <i class="fa fa-eye"></i></a>
                                                                        <a href="{{ route('myupdatepost_get', ['slug' => $new->slug]) }}" class="btn btn-warning"> <i class="fa fa-edit"></i></a>
                                                                        <a class="btn btn-danger" href="javascript:void(0)"
                                                                           onclick="mynewsdelete({{$new->id}})">
                                                                            <i class="fa fa-trash"></i>
                                                                        </a>

                                                                        <form id="delete-my-news-{{$new->id}}" action="{{ route('mydeletepost', ['id' => $new->id]) }}" method="POST" style="display: none;">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                        </form>
                                                                    @else
                                                                        <p class="text-danger"> <i class="fa fa-times-circle"></i> Yönetici tarafından bu içerik engellendi</p>
                                                                @endif

                                                                <div class="text-right mr-5">@if($new->state === 0) <h5 class="btn btn-outline-danger">PASİF</h5> @else <h5 class="btn btn-outline-success">AKTİF</h5> @endif</div>
                                                            </div>
                                                        </div>
                                                        <div class="like-comm m-t-20">
                                                            @if($new->block === 1)
                                                                <a data-toggle="modal" data-target="#exampleModalLong-{{ $new->id }}" href="{{ route('blog_detail', ['slug' => $new->slug]) }}" class="link m-r-10">{{ $new->comments->count() }} yorum</a>
                                                                <a href="javascript:void(0)" onclick="likeBlog({{ $new->id }})" class="link m-r-10"><i class="fa fa-heart @forelse($new->likes as $like) @if($like->user_id === auth()->user()->id) text-danger @else @endif @empty @endforelse"></i> {{ $new->likes->count() }} Love</a>
                                                            @endif
                                                            <a href="{{ route('category_blogs', ['slug' => $new->category->slug]) }}" target="_blank" class="btn btn-outline-secondary">{{ $new->category->name }}</a>


                                                            @if($new->block === 1)
                                                            <form id="likeBlog-{{$new->id}}" action="{{ route('add-like', ['id' => $new->id]) }}" method="POST" style="display: none;">
                                                                @csrf
                                                                @method('POST')
                                                            </form>
                                                            @endif

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="exampleModalLong-{{ $new->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLongTitle">
                                                                                {{ $new->title }}</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="row">
                                                                            @forelse($new->comments as $comment)
                                                                                @if($comment->state === 1)
                                                                                    <div class="col-md-2">
                                                                                        <img src="{{ $comment->user->avatar }}" class="mx-auto rounded-circle" width="50px" height="50px">
                                                                                    </div>
                                                                                    <div class="col-md-10">
                                                                                        <h6>{{ $comment->user->name }} <small>@if($comment->user_id === auth()->user()->id) (Yazar) @endif</small></h6>
                                                                                        <p>{{ $comment->comment }}</p>
                                                                                    </div>
                                                                                @endif
                                                                            @empty
                                                                                <div class="col-md-12 text-center">
                                                                                    <p>Henüz bir yorum yapılmamış</p>
                                                                                </div>
                                                                            @endforelse
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                                @empty
                                                <div class="sl-item">
                                                    Henüz bir gönderi paylaşılmadı.
                                                </div>
                                            @endforelse
                                            {{ $news->links('partials.profile_paginate') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="previous-month" role="tabpanel" aria-labelledby="pills-setting-tab">
                                    <div class="card-body">
                                        <form class="form-horizontal form-material" method="POST" action="{{ route('myprofile_update') }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <h4 class="card-title m-t-40">Resim</h4>
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="row">
                                                        <div class="col-md-5 text-center">
                                                            <img src="{{ auth()->user()->avatar }}" width="100" height="100" alt="" style="opacity: 0.5!important;">
                                                            <div class="row">
                                                                <div class="col-md-12 text-warning">Mevcut Resim</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 text-center mt-4">
                                                            <i class="fa fa-arrow-alt-circle-right fa-3x text-success" style="margin-left: 10px!important; margin-right: 5px!important;"></i>
                                                        </div>
                                                        <div class="col-md-5 text-center">
                                                            <img id="blah" width="100" height="100" alt="Yeni görsel seçilmedi">
                                                            <div class="row" id="newImageText">
                                                                <div class="col-md-12 text-success">Yeni Görsel</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Yüklü</span>
                                                        </div>
                                                        <div class="custom-file">
                                                            <input type="file" name="avatar"  class="custom-file-input" id="inputGroupFile01" accept=".png, .jpg, .jpeg">
                                                            <label class="custom-file-label" for="inputGroupFile01">Resim seçin</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                                </div>
                                                <input name="name" type="text" class="form-control" placeholder="{{ auth()->user()->name }}">
                                            </div>

                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-key"></i></span>
                                                </div>
                                                <input type="password" name="password" class="form-control">
                                            </div>

                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                                </div>
                                                <input name="phone" type="text" maxlength="10" class="form-control" placeholder="{{ auth()->user()->phone }}">
                                            </div>

                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-briefcase"></i></span>
                                                </div>
                                                <input name="job" type="text" maxlength="50" class="form-control" placeholder="{{ auth()->user()->job }}">
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-12">Adress</label>
                                                <div class="col-md-12">
                                                    <textarea class="form-control" name="address" rows="8" cols="250" style="min-height:50px;max-height:150px;height:100%;width:100%;">{{ auth()->user()->address }}</textarea>
                                                </div>
                                            </div>

                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                                                </div>
                                                <input type="text" name="facebook" class="form-control" placeholder="https://facebook.com/" value="{{ auth()->user()->facebook }}">
                                            </div>

                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                                                </div>
                                                <input name="twitter" type="text" class="form-control" placeholder="https://twitter.com/" value="{{ auth()->user()->twitter }}">
                                            </div>

                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fab fa-youtube"></i></span>
                                                </div>
                                                <input name="youtube" type="text" class="form-control" placeholder="https://youtube.com/" value="{{ auth()->user()->youtube }}">
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <button class="btn btn-success" type="submit" id="updateButton">Profili Güncelle</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
@endsection

@section('stylesheet')
    <style>
        .disabledbutton {
            pointer-events: none;
            opacity: 0;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/prism.css') }}" type="text/css">
@endsection

@section('javascript')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#inputGroupFile01").change(function() {
            readURL(this);
        });
    </script>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#inputGroupFile01").change(function() {
            readURL(this);
            changeImageStateText();
        });

        function changeImageStateText() {
            $('#newImageText').removeClass('disabledbutton');
        }

        $(document).ready(function () {
            $('#newImageText').addClass('disabledbutton');
        });
    </script>

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

    <script>
        function mynewsdelete(id) {
            var answer = confirm('Silmek istediğinize emin misiniz ?');

            if(answer == true) {
                event.preventDefault();
                document.getElementById('delete-my-news-'+id).submit();
            }
        }

        function likeBlog(id) {
            event.preventDefault();
            document.getElementById('likeBlog-' + id).submit();
        }
    </script>
@endsection
