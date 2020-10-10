@extends('admin.layouts.master')
@section('content')
    <div class="container-fluid">
        <form action="{{ route('mynewpost') }}" method="POST" enctype="multipart/form-data">
            @csrf
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
                            <h4 class="card-title">Başlık</h4>
                            <div class="form-group">
                                <input type="text" name="title" class="form-control" id="nametext" aria-describedby="name" placeholder="Slayt Başlığı Girin ...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 col-md-6 offset-md-3">
                    <h4 class="card-title m-t-40">Resim</h4>
                    <div class="card">
                        <div class="card-header">
                            <img id="blah" width="100" height="100" alt="">
                        </div>
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Yüklü</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="inputGroupFile01" accept=".png, .jpg, .jpeg">
                                    <label class="custom-file-label" for="inputGroupFile01">Resim seçin</label>
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
                            <h4 class="card-title">Kategori</h4>
                            <div class="form-group m-b-30">
                                <label class="mr-sm-2" for="inlineFormCustomSelect">Select</label>
                                <select class="custom-select mr-sm-2" name="category" id="inlineFormCustomSelect">
                                    @forelse($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @empty
                                    @endforelse
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
                                    <input type="radio" name="state" class="custom-control-input" id="customControlValidation2" value="active">
                                    <label class="custom-control-label" for="customControlValidation2">Aktif</label>
                                </div>
                            </div>
                            <div class="form-check form-check-inline">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="state" class="custom-control-input" id="customControlValidation3" value="pass">
                                    <label class="custom-control-label" for="customControlValidation3">Pasif</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Açıklama</h4>
                            <textarea class="form-control" name="summary" id="exampleFormControlTextarea1" rows="8" cols="250" style="min-height:100px;max-height:200px;height:100%;width:100%;"></textarea>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">İçerik</h4>
                            <textarea id="mymce" name="content_news" rows="4" cols="50"></textarea>
                        </div>
                    </div>

                    <input type="submit" class="btn btn-primary" value="Kaydet" />
                </div>
            </div>
        </form>
    </div>
@endsection

@section('javascript')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#inputGroupFile01").change(function() {
            readURL(this);
        });
    </script>

    <script src="{{ asset('js/prism.js') }}" data-manuel></script>
    <script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/libs/tinymce/themes/modern/theme.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            if ($("#mymce").length > 0) {
                tinymce.init({
                    selector: "textarea#mymce",
                    theme: "modern",
                    height: 300,
                    plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "save table contextmenu directionality emoticons template paste textcolor codesample"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons | codesample",
                    codesample_global_prismjs: true,
                    codesample_languages: [
                        { text: 'HTML/XML', value: 'markup' },
                        { text: 'JavaScript', value: 'javascript' },
                        { text: 'CSS', value: 'css' },
                        { text: 'PHP', value: 'php' },
                        { text: 'Ruby', value: 'ruby' },
                        { text: 'Python', value: 'python' },
                        { text: 'Java', value: 'java' },
                        { text: 'C', value: 'c' },
                        { text: 'C#', value: 'csharp' },
                        { text: 'C++', value: 'cpp' }
                    ],

                });
            }
        });
    </script>
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('css/prism.css') }}" type="text/css">
@endsection
