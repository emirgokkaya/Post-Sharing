@extends('admin.layouts.master')
@section('content')
    <div class="container-fluid">
        <form action="#" method="POST">
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
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 offset-3">
                    <div class="card">
                        <div class="card-header text-center">
                            <h2>{{ $user->name }}</h2>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <i class="icon-Email fa-2x mr-3"></i> <span class="shadow">{{ $user->email }}</span><br>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <i class="icon-Phone-2 fa-2x mr-3"></i> <span class="shadow">+90 {{ $user->phone }}</span> <br>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <i class="icon-Worker fa-2x mr-3"></i> <span class="shadow">{{ $user->job }}</span> <br>
                                </div>
                            </div>

                            <div class="row mb-5">
                                <div class="col-md-12">
                                    <i class="icon-Address-Book fa-2x mr-3"></i> <span class="shadow">{{ $user->address }}</span> <br>
                                </div>
                            </div>

                            <div class="row text-center">
                                <div class="col-md-4"><a href="https://facebook.com/{{$user->facebook}}" class="mt-3">
                                        <i class="fab fa-facebook fa-2x mr-3" style="color: #3b5999 !important;"></i>
                                    </a>
                                </div>
                                <div class="col-md-4"><a href="https://twitter.com/{{$user->twitter}}">
                                        <i class="fab fa-twitter fa-2x mr-3" style="color: #55acee!important;"></i>
                                    </a>
                                </div>
                                <div class="col-md-4"><a href="https://youtube.com/{{$user->youtube}}">
                                        <i class="fab fa-youtube fa-2x" style="color: #cd201f!important;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 offset-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group m-b-30">
                                <label class="mr-sm-2" for="inlineFormCustomSelect">Kullanıcı Rolü</label>
                                <select class="custom-select mr-sm-2" name="user_role" id="inlineFormCustomSelect">
                                    <option value="admin" @if($user->role === "admin") selected @endif>Admin</option>
                                    <option value="member" @if($user->role === "member") selected @endif>Üye</option>
                                    <option value="editor" @if($user->role === "editor") selected @endif>Editör</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Durum</h4>
                            <div class="form-check form-check-inline">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="state" class="custom-control-input" id="customControlValidation2" value="active" @if($user->state === 1) checked="checked" @endif>
                                    <label class="custom-control-label" for="customControlValidation2">Aktif</label>
                                </div>
                            </div>
                            <div class="form-check form-check-inline">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="state" class="custom-control-input" id="customControlValidation3" value="pass" @if($user->state === 0) checked="checked" @endif>
                                    <label class="custom-control-label" for="customControlValidation3">Pasif</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Kaydet" />
                </div>
            </div>
        </form>
    </div>
@endsection
