@extends('admin.layouts.master')

@section('content')

    <div class="container-fluid" style="color: gray">
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
                    <div class="card-header row">
                        <div class="col-md-6">
                            @if($news->count() != 0)
                            <form action="{{ route('delete-all-news') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Tüm haberleri silmek istediğinize emin misiniz ? (Bu işlem geri alınamaz !!)')">Tümünü Sil</button>
                            </form>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">

                            <table id="slider_table" class="display">
                                <thead>
                                <tr class="text-center">
                                    <th>Başlık</th>
                                    <th>Resim</th>
                                    <th>Durum</th>
                                    <th>Kategori</th>
                                    <th>Yazar</th>
                                    <th>Düzenle</th>
                                    <th>Sil</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($news as $new)
                                    <tr class="text-center">
                                        <td>{{ $new->title }}</td>
                                        <td>
                                            <img src="{{ $new->image }}" alt="" width="100" height="100">
                                        </td>
                                        <td>
                                            @if($new->block === 1)
                                                    <i class="text-success fa fa-check-circle"></i>
                                            @else
                                                <i class="text-danger fa fa-times-circle"></i>
                                            @endif
                                        </td>
                                        <td>{{ $new->category->name }}</td>
                                        <td>{{ $new->user->name }}</td>
                                        <td>
                                            <a href="javascript:void(0)" onclick="changeStatus({{ $new->id }})" class="btn btn-info">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <form id="change-blog-status-{{$new->id}}" action="{{ route('edit-news-put', ['slug' => $new->slug]) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('PUT')
                                            </form>

                                        </td>
                                        <td>
                                            <form action="{{ route('delete-news', ['id' => $new->id]) }}" method="POST">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="btn btn-danger" value="" onclick="return confirm('Silmek istediğine emin misin ?')" style="">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty

                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('stylesheet')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables.min.css') }}">
@endsection




@section('javascript')
    <script src="{{ asset('js/datatables.min.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready( function () {
            $('#slider_table').DataTable();
        } );
    </script>

    <script>
        function changeStatus(id) {
            event.preventDefault();
            document.getElementById('change-blog-status-'+id).submit();
        }
    </script>
@endsection
