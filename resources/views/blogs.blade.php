@extends('layouts.master')

@section('content')
    <!-- Page title -->
    <div class="page-title">
        <div class="container">
            @if(isset($category_name))
                <h2>{{ \Illuminate\Support\Str::limit($category_name, 20) }} Kategorisine Ait Bloglar</h2>
            @elseif(isset($user_name))
                <h2>{{ \Illuminate\Support\Str::limit($user_name, 20) }} Kişisine Ait Bloglar</h2>
            @else
                <h2>Tüm Bloglar</h2>
            @endif
            <ul class="nav">
                <li><a href="{{ route('index') }}">Anasayfa</a></li>
                @if(isset($category_name))
                    <li><a href="{{ route('categories') }}">Kategori</a></li>
                    <li>{{ \Illuminate\Support\Str::limit($category_name, 20) }}</li>
                @elseif(isset($user_name))
                    <li><a href="{{ route('blogs') }}">Bloglar</a></li>
                    <li>{{ \Illuminate\Support\Str::limit($user_name, 20) }}</li>
                @else
                    <li>Bloglar</li>
                @endif
            </ul>
        </div>
    </div>
    <!-- End of Page title -->
    <div class="container pt-120 pb-90">
        @forelse($blogs as $blog)
            <!-- Post -->
            <div class="post-default post-has-right-thumb">
                <div class="d-flex flex-wrap">
                    <div class="post-thumb align-self-stretch order-md-2">
                        <a href="{{ route('blog_detail', ['slug' => $blog->slug]) }}">
                            <div data-bg-img="{{ $blog->resize_image }}"></div>
                        </a>
                    </div>
                    <div class="post-data order-md-1">
                        <!-- Category -->
                        <div class="cats"><a href="{{ route('category_blogs', ['slug' => $blog->category->slug]) }}">{{ $blog->category->name }}</a></div>
                        <!-- Title -->
                        <div class="title">
                            <h2><a href="{{ route('blog_detail', ['slug' => $blog->slug]) }}">{{ $blog->title }}</a></h2>
                        </div>
                        <!-- Post Meta -->
                        <ul class="nav meta align-items-center">
                            <li class="meta-author">
                                <img src="{{ $blog->user->avatar }}" alt="" class="img-fluid">
                                <a href="{{ route('user_blogs', ['name' => $blog->user->name, 'id' => $blog->user->id]) }}">{{ $blog->user->name }}</a>
                            </li>
                            <li class="meta-date"><p>{{ date('j F Y') }}</p></li>
                        </ul>
                        <!-- Post Desc -->
                        <div class="desc">
                            <p>
                                {{ \Illuminate\Support\Str::limit($blog->summary, 300) }}
                            </p>
                        </div>
                        <!-- Read More Button -->
                        <a href="{{ route('blog_detail', ['slug' => $blog->slug]) }}" class="btn btn-primary">Daha Fazla</a>
                    </div>
                </div>
            </div>
            <!-- End of Post -->
        @empty
            <h2 class="text-center text-danger">Henüz bir blog girilmemiş</h2>
        @endforelse

        {{ $blogs->links('partials.blog_paginate') }}
    </div>
@endsection
