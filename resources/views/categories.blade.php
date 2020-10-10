@extends('layouts.master')

@section('content')
    <!-- Page title -->
    <div class="page-title">
        <div class="container">
            <h2>Tüm Kategoriler</h2>
            <ul class="nav">
                <li><a href="{{ route('index') }}">Anasayfa</a></li>
                <li>Kategoriler</li>
            </ul>
        </div>
    </div>
    <!-- End of Page title -->

    <div class="container pt-120 pb-90">
        <div class="row">
            @forelse($categories as $category)
            <!-- Category -->
            <div class="col-md-6">
                <div class="my-post-category">
                    @php $array = ['#3b5998', '#dd4b39', '#007bb6', '#00bf8f', '#fffc00', '#ff0084', '#0072b1', '#00aced', '#bb0000', '#517fa4'] @endphp
                    <a href="{{ route('category_blogs', ['slug' => $category->slug]) }}" style="background-color: {{ $array[rand(0, count($array)-1)] }}!important;" class="d-flex align-items-center justify-content-center">
                        <div class="cat-title">{{ \Illuminate\Support\Str::limit($category->name, 20) }} ({{$category->news->count()}})</div>
                    </a>
                </div>
            </div>
            @empty
                <div class="col-md-12 text-center">
                    <h2 class="text-danger">Henüz bir kategori girilmemiş</h2>
                </div>
            @endforelse
            <!-- End of Category -->
        </div>

        <div class="row">
            <div class="col-md-12">
                {{ $categories->links('partials.blog_paginate') }}
            </div>
        </div>
    </div>
@endsection
