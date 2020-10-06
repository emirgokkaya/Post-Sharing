@extends('admin.layouts.master')
@section('content')
    <div class="container-fluid">
<form action="{{ route('edit-category-put', ['slug' => $category->slug]) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row mt-5">
        <div class="col-sm-12 col-md-6 offset-md-3">

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


            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Kategori İsmi</h4>
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" id="nametext" aria-describedby="name" value="{{ $category->name }}">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="submit" class="btn btn-primary" value="Kaydet" />
            </div>
        </div>
    </div>
</form>
    </div>

@endsection
