@extends('admin.layouts.master')

@section('content')
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Welcome back  -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card  bg-light no-card-border">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="m-r-10">
                                <img src="{{ auth()->user()->avatar }}" alt="user" width="60" class="rounded-circle" height="60" />
                            </div>
                            <div>
                                <h3 class="m-b-0">Hoşgeldin, {{ auth()->user()->name }}</h3>
                                <span>{{ date('l, j F Y')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Sales Summery -->
        <!-- ============================================================== -->
        <div class="card-group">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <h3>@php $users_count = \App\User::count(); echo $users_count @endphp</h3>
                            <h6 class="card-subtitle">Toplam Üye</h6>
                        </div>
                        <div class="col-4 text-right"><i class="fa fa-user-circle fa-3x"></i></div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <h3>@php $categor_count = \App\NewsByCategory::count(); echo $categor_count; @endphp</h3>
                            <h6 class="card-subtitle">Toplam Kategori</h6>
                        </div>
                        <div class="col-4 text-right"><i class="fa fa-list fa-3x"></i></div>

                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <h3>@php $news_count = \App\News::count(); echo $news_count; @endphp</h3>
                            <h6 class="card-subtitle">Toplam Haber</h6>
                        </div>
                        <div class="col-4 text-right"><i class="fab fa-blogger fa-3x"></i></div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <h3>@php $comment_count = \App\Comment::count(); echo $comment_count @endphp</h3>
                            <h6 class="card-subtitle">Toplam Yorum</h6>
                        </div>
                        <div class="col-4 text-right"><i class="fa fa-comment fa-3x"></i></div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <h3>@php $likes_count = \App\Like::count(); echo $likes_count @endphp</h3>
                            <h6 class="card-subtitle">Toplam Like</h6>
                        </div>
                        <div class="col-4 text-right"><i class="fa fa-heart fa-3x"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- project of the month -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-sm-12 col-lg-7">
                <div class="card">
                    <div class="card-body p-b-0">
                        <h4 class="card-title">Popüler Yazarlar</h4>
                        <div class="table-responsive">
                            <table class="table v-middle">
                                <thead>
                                <tr>
                                    <th class="border-top-0">Yazar</th>
                                    <th class="border-top-0">Yorum</th>
                                    <th class="border-top-0">Beğeni</th>
                                    <th class="border-top-0">Post</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($popular_users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="m-r-10">
                                                <img src="{{ $user->avatar }}" alt="user" class="rounded-circle" width="45">
                                            </div>
                                            <div class="">
                                                <h4 class="m-b-0 font-16">{{ $user->name }}</h4>
                                                <span>{{ $user->email }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->comments->count() }}</td>
                                    <td>{{ $user->likes->count() }}</td>
                                    <td class="font-medium">{{ $user->news->count() }}</td>
                                </tr>
                                @empty
                                    <h4 class="text-center text-danger">Popüler kullanıcılar henüz listelenmedi</h4>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @if($weather != null)
            <div class="col-sm-12 col-lg-5">
                <div class="card bg-light">
                    <div class="card-body">
                        <h4 class="card-title">Hava Durumu</h4>
                        <div class="d-flex align-items-center flex-row m-t-30">
                            <div class="display-5 text-info">
                                <img src="{{ $weather->result[0]->icon }}" width="100px">
                                <span>{{ (int)$weather->result[0]->degree }}
                                            <sup>°</sup>
                                        </span>
                            </div>
                            <div class="m-l-10">
                                <h3 class="m-b-0">{{ $weather->result[0]->day }}</h3>
                                <small>{{ $weather->city }}</small>
                            </div>
                        </div>
                        <table class="table no-border mini-table m-t-20">
                            <tbody>
                            <tr>
                                <td class="text-muted">Durum</td>
                                <td class="font-medium">{{ ucwords($weather->result[0]->description) }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Nem</td>
                                <td class="font-medium">{{ $weather->result[0]->humidity }}%</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Max</td>
                                <td class="font-medium">{{ (int)$weather->result[0]->max }}<sup>°</sup></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Min</td>
                                <td class="font-medium">{{ (int)$weather->result[0]->min }}<sup>°</sup></td>
                            </tr>
                            </tbody>
                        </table>
                        <ul class="row list-style-none text-center m-t-30">
                            <li class="col-2">
                                <h4 class="text-info">
                                    <img src="{{ $weather->result[1]->icon }}" width="20px" alt="">
                                </h4>
                                <small class="d-block text-muted">{{ \Illuminate\Support\Str::limit($weather->result[1]->day, 6) }}</small>
                                <h3 class="m-t-5">{{ (int)$weather->result[1]->degree }}
                                    <sup>°</sup>
                                </h3>
                            </li>
                            <li class="col-2">
                                <h4 class="text-info">
                                    <img src="{{ $weather->result[2]->icon }}" width="20px" alt="">
                                </h4>
                                <small class="d-block text-muted">{{ \Illuminate\Support\Str::limit($weather->result[2]->day, 6) }}</small>
                                <h3 class="m-t-5">{{ (int)$weather->result[2]->degree }}
                                    <sup>°</sup>
                                </h3>
                            </li>
                            <li class="col-2">
                                <h4 class="text-info">
                                    <img src="{{ $weather->result[3]->icon }}" width="20px" alt="">
                                </h4>
                                <small class="d-block text-muted">{{ \Illuminate\Support\Str::limit($weather->result[3]->day, 6) }}</small>
                                <h3 class="m-t-5">{{ (int)$weather->result[3]->degree }}
                                    <sup>°</sup>
                                </h3>
                            </li>
                            <li class="col-2">
                                <h4 class="text-info">
                                    <img src="{{ $weather->result[4]->icon }}" width="20px" alt="">
                                </h4>
                                <small class="d-block text-muted">{{ \Illuminate\Support\Str::limit($weather->result[4]->day, 6) }}</small>
                                <h3 class="m-t-5">{{ (int)$weather->result[4]->degree }}
                                    <sup>°</sup>
                                </h3>
                            </li>
                            <li class="col-2">
                                <h4 class="text-info">
                                    <img src="{{ $weather->result[5]->icon }}" width="20px" alt="">
                                </h4>
                                <small class="d-block text-muted">{{ \Illuminate\Support\Str::limit($weather->result[5]->day, 6) }}</small>
                                <h3 class="m-t-5">{{ (int)$weather->result[5]->degree }}
                                    <sup>°</sup>
                                </h3>
                            </li>
                            <li class="col-2">
                                <h4 class="text-info">
                                    <img src="{{ $weather->result[6]->icon }}" width="20px" alt="">
                                </h4>
                                <small class="d-block text-muted">{{ \Illuminate\Support\Str::limit($weather->result[6]->day, 6) }}</small>
                                <h3 class="m-t-5">{{ (int)$weather->result[6]->degree }}
                                    <sup>°</sup>
                                </h3>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <!-- ============================================================== -->
        <!-- Task, Feeds -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- column -->
            <div class="col-sm-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Bülten</h4>
                        <div class="todo-widget scrollable" style="height:450px;">
                                <ul class=" todo-list list-group m-b-0" data-role="tasklist">
                                    @forelse($bulletin as $user)
                                        <li class="list-group-item todo-item" data-role="task">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck-{{ $user->id }}" value="{{ $user->email }}">
                                                <label class="custom-control-label todo-label" for="customCheck-{{ $user->id }}">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <span class="todo-desc">{{ $user->email }}</span>
                                                        </div>
                                                        <div class="col-2 text-right">
                                                            <span class="badge badge-pill badge-secondary">{{ date('l, j F Y', strtotime($user->created_at)), 20 }}</span>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </li>
                                    @empty
                                        <h5 class="text-danger text-center">Henüz bültende kayıtlı kullanıcı yok</h5>
                                    @endforelse
                                </ul>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-6">
                                <button class="btn btn-primary" onclick="selectAllBulten()">Tümünü Seç</button>
                            </div>
                            <div class="col-6 text-right">
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#messageSend" data-whatever="@getbootstrap">Mesaj Gönder</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="messageSend" tabindex="-1" role="dialog" aria-labelledby="messageSendModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Bülten Mesaj</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label">Mesaj</label>
                                    <textarea class="form-control" name="message" id="message-text" rows="8" cols="250" style="min-height:100px;max-height:200px;height:100%;width:100%;"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" onclick="sendMessage({{ $bulletin }})" class="btn btn-info">Gönder</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- column -->
            <div class="col-sm-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Saat</h4>
                        <div class="text-center">
                            <canvas id="canvas" width="300%" height="300%">
                            </canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
@endsection

@section('javascript')
    <script>
        function selectAllBulten() {
            if($(".custom-control-input").prop("checked") === true){
                $(".custom-control-input").prop("checked", false);
            } else {
                $(".custom-control-input").prop("checked", true);
            }
        }

        function ajaxUsing(userList, message) {
            $.ajax({
                type    : 'POST',
                url     : '/admin/bulten/mesaj',
                async: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "userList": JSON.stringify(userList),
                    "message": message,
                },
                success: function (result) {
                    toastr[result.status](result.message);
                },
                traditional: true,

            })
        }

        function sendMessage(bulletin, message) {
            var userList = [];

            bulletin.forEach(element => {
                if($('#customCheck-' + element.id).prop('checked') === true) {
                    userList.push(element.email);
                }
            });

            message = $('#message-text').val()
            ajaxUsing(userList, message);
        }


        var canvas = document.getElementById("canvas");
        var ctx = canvas.getContext("2d");
        var radius = canvas.height / 2;
        ctx.translate(radius, radius);
        radius = radius * 0.90
        setInterval(drawClock, 1000);

        function drawClock() {
            drawFace(ctx, radius);
            drawNumbers(ctx, radius);
            drawTime(ctx, radius);
        }

        function drawFace(ctx, radius) {
            var grad;
            ctx.beginPath();
            ctx.arc(0, 0, radius, 0, 2*Math.PI);
            ctx.fillStyle = 'white';
            ctx.fill();
            grad = ctx.createRadialGradient(0,0,radius*0.95, 0,0,radius*1.05);
            grad.addColorStop(0, '#333');
            grad.addColorStop(0.5, 'white');
            grad.addColorStop(1, '#333');
            ctx.strokeStyle = grad;
            ctx.lineWidth = radius*0.1;
            ctx.stroke();
            ctx.beginPath();
            ctx.arc(0, 0, radius*0.1, 0, 2*Math.PI);
            ctx.fillStyle = '#333';
            ctx.fill();
        }

        function drawNumbers(ctx, radius) {
            var ang;
            var num;
            ctx.font = radius*0.15 + "px arial";
            ctx.textBaseline="middle";
            ctx.textAlign="center";
            for(num = 1; num < 13; num++){
                ang = num * Math.PI / 6;
                ctx.rotate(ang);
                ctx.translate(0, -radius*0.85);
                ctx.rotate(-ang);
                ctx.fillText(num.toString(), 0, 0);
                ctx.rotate(ang);
                ctx.translate(0, radius*0.85);
                ctx.rotate(-ang);
            }
        }

        function drawTime(ctx, radius){
            var now = new Date();
            var hour = now.getHours();
            var minute = now.getMinutes();
            var second = now.getSeconds();
            //hour
            hour=hour%12;
            hour=(hour*Math.PI/6)+
                (minute*Math.PI/(6*60))+
                (second*Math.PI/(360*60));
            drawHand(ctx, hour, radius*0.5, radius*0.07);
            //minute
            minute=(minute*Math.PI/30)+(second*Math.PI/(30*60));
            drawHand(ctx, minute, radius*0.8, radius*0.07);
            // second
            second=(second*Math.PI/30);
            drawHand(ctx, second, radius*0.9, radius*0.02);
        }

        function drawHand(ctx, pos, length, width) {
            ctx.beginPath();
            ctx.lineWidth = width;
            ctx.lineCap = "round";
            ctx.moveTo(0,0);
            ctx.rotate(pos);
            ctx.lineTo(0, -length);
            ctx.stroke();
            ctx.rotate(-pos);
        }

    </script>
@endsection
