@extends('admin.layouts.master')

@section('content')

    <div class="container-fluid" style="color: gray">
        <div class="row mt-5">
            <div class="col-sm-12 col-md-6 offset-md-3">

                <div class="card">
                    <div class="card-header row">
                        <div class="col-md-6">
                            @if($comments->count() != 0)
                            <button id="deleteAllComments" onclick="deleteAllComments()" class="btn btn-danger">
                                Tümünü Sil
                            </button>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">

                            <table id="slider_table" class="display">
                                <thead>
                                <tr class="text-center">
                                    <th>Kullanıcı</th>
                                    <th>Haber</th>
                                    <th>Durum</th>
                                    <th>Yorum</th>
                                    <th>Durum Değiştir</th>
                                    <th>Sil</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($comments as $comment)
                                    <tr class="text-left" id="comment_{{ $comment->id }}">
                                        <td class="text-center">{{ $comment->user->name }}</td>

                                        <td>{{ $comment->news->title }}</td>
                                        <td class="text-center">
                                            <i id="status_active_{{$comment->id}}" class="@if($comment->state === 1) fa fa-check-circle text-success @else fa fa-times-circle text-danger @endif"></i>
                                        </td>
                                        <td>{{ \Illuminate\Support\Str::limit($comment->comment, 100) }}</td>
                                        <td class="text-center">
                                            <button onclick="updateComment({{$comment->id}})" class="btn btn-info">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-danger" onclick="deleteComment({{ $comment->id }})">
                                                <i class="fa fa-trash"></i>
                                            </button>
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
        function updateComment(id) {
            $.ajax({
                type    : 'PUT',
                url     : '/admin/yorumlar/yorum-duzenle/'+id,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                success: function (result) {
                    if(result.state === true) {
                        $('#status_active_' + id).removeClass('fa fa-times-circle text-danger')
                        $('#status_active_' + id).addClass('fa fa-check-circle text-success')
                        toastr.success('Yorum aktif hale getirildi')
                    }
                    else {
                        $('#status_active_' + id).removeClass('fa fa-check-circle text-success')
                        $('#status_active_' + id).addClass('fa fa-times-circle text-danger')
                        toastr.warning("Yorum pasif hale getirildi")
                    }
                },
                dataType: 'json',
                encode  : true
            });
        }

        function deleteComment(id) {
            if(confirm("Yorumu silmek istediğinize emin misiniz ? (Bu işlem geri alınamaz)") === true) {
                $.ajax({
                    type    : 'DELETE',
                    url     : '/admin/yorumlar/yorum-sil/' + id,
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (result) {
                        $("#comment_" + id).remove();
                        toastr.success(result.user.name + ' kullanıcısına ait yorum başarıyla silindi');
                        if($('tr').length-1 === 0) {
                            $('#deleteAllComments').remove();
                        }
                    }
                })
            }
        }

        function deleteAllComments() {
            if(confirm("Tüm yorumları silmek istediğinize emin misiniz ? (Bu işlem geri alınamaz)") === true) {
                $.ajax({
                    type: 'DELETE',
                    url: '/admin/yorumlar/tum-yorumlari-sil/',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (result) {
                        $("#slider_table").remove();
                        $("#deleteAllComments").remove();
                        toastr.success("Tüm yorumlar başarıyla silindi");
                    }
                })
            }
        }

    </script>
@endsection

@section('stylesheet')
    <link href="{{ asset('../../assets/extra-libs/toastr/dist/build/toastr.min.css') }}" rel="stylesheet">
@endsection

