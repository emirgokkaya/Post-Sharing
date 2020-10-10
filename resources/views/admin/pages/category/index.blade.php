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
                            @if($categories->count() != 0)
                            <form action="{{ route('delete-all-category') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Tüm kategorileri silmek istediğinize emin misiniz ? (Bu işlem geri alınamaz !!)')">Tümünü Sil</button>
                            </form>
                            @endif
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('add-category') }}" class="btn btn-info">Ekle</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">

                            <table id="slider_table" class="display">
                                <thead>
                                <tr class="text-center">
                                    <th>Başlık</th>
                                    <th>Düzenle</th>
                                    <th>Sil</th>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse($categories as $category)
                                    <tr class="text-center">
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            <a href="{{ route('edit-category', ['slug' => $category->slug]) }}" class="btn btn-info">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ route('delete-category', ['id' => $category->id]) }}" method="POST">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="btn btn-danger" value="" onclick="return confirm('Silmek istediğine emin misin ?')">
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
@endsection
