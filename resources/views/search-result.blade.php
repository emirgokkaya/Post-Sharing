@extends('layouts.master')

@section('content')
<!-- Page title -->
<div class="page-title search-title">
    <div class="container">
        <h2><span>Arama Sonuçları: </span> {{ \Illuminate\Support\Str::limit($search, 40) }} </h2>
    </div>
</div>
<!-- End of Page title -->
<div class="container pt-120 pb-90">
    <div class="row">
        @forelse($news as $new)
        <div class="col-sm-6">
            <!-- Post -->
            <div class="post-default">
                <div class="post-thumb">
                    <a href="{{ route('blog_detail', ['slug' => $new->slug]) }}">
                        <img src="{{ $new->image }}" alt="" class="img-fluid">
                    </a>
                </div>
                <div class="post-data">
                    <!-- Category -->
                    <div class="cats"><a href="{{ route('category_blogs', ['slug' => $new->category->slug]) }}">{{ $new->category->name }}</a></div>
                    <!-- Title -->
                    <div class="title">
                        <h2><a href="{{ route('blog_detail', ['slug' => $new->slug]) }}">{{ \Illuminate\Support\Str::limit($new->title, 50) }}</a></h2>
                    </div>
                    <!-- Post Desc -->
                    <div class="desc">
                        <p>
                            {{ \Illuminate\Support\Str::limit($new->summary, 300) }}
                        </p>
                    </div>
                </div>
            </div>
            <!-- End of Post -->
        </div>
        @empty
            <div class="col-sm-12 offset-4">
                <h3 class="text-danger">Arama Sonucu Bulunamadı</h3>
            </div>
        @endforelse
    </div>

    <!-- Post Pagination -->
    {{ $news->links('partials.blog_paginate') }}
    <!-- End of Post Pagination -->
</div>
@endsection
