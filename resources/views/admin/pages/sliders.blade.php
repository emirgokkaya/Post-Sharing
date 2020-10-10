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
                            @if($sliders->count() != 0)
                            <form action="{{ route('delete_all_slider') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Tüm slaytları silmek istediğinize emin misiniz ? (Bu işlem geri alınamaz !!)')">Tümünü Sil</button>
                            </form>
                            @endif
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('add_slider') }}" class="btn btn-info">Ekle</a>
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
                                    <th>Yazar</th>
                                    <th>Düzenle</th>
                                    <th>Sil</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($sliders as $slider)
                                    <tr class="text-center">
                                        <td>{{ $slider->title }}</td>
                                        <td>
                                            <img src="{{ $slider->image }}" alt="" width="100" height="100">
                                        </td>
                                        <td>
                                            @if($slider->state == 1)
                                                <i class="text-success fa fa-check-circle"></i>
                                            @else
                                                <i class="text-danger fa fa-times-circle"></i>
                                            @endif
                                        </td>
                                        <td>{{ $slider->user->name }}</td>
                                        <td>
                                            <a href="{{ route('edit_slider', ['slug' => $slider->slug]) }}" class="btn btn-info">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ route('delete_slider', ['id' => $slider->id]) }}" method="POST">
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
@endsection
