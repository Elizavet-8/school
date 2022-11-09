@extends('layouts.admin_layout')

@section('title', 'Файлы')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Добавление файла в тему "{{$theme->title}}"</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </section>

    <!-- Main content -->
    <section class="content">
        <form method="post" action="{{ route('file.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
                <div class="col-12">
                    <a href="{{ route('theme.files', $theme['id']) }}" class="btn btn-secondary">Назад</a>
                    <input type="submit" value="Добавить файл" class="btn btn-success float-right">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Обязательные параметры</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Название</label>
                                <input value="{{ old('title') }}" name="title" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="inputStatus2">Секция</label>
                                <select name="section_id" id="inputStatus2" class="form-control custom-select">
                                    @foreach ($sections as $section)
                                    <option value="{{$section->id}}">{{$section->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Файл(Ctrl + V)</label>
                                <input style="height: 46px;" value="{{ old('file') }}" name="file" type="file"
                                       class="form-control"  id="document_attachment_doc">
                            </div>
                            <img class="preview" id="preview" src="{{ old('file') }}"/>
                            <input value="{{$theme->id}}" name="theme_id" type="hidden">
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </form>
    </section>
    <!-- /.content -->
@endsection
@push('styles')
    <style>
        .preview {
            align-items: center;
            border: 1px solid #cbd5e0;
            display: flex;
            justify-content: center;

            margin-top: 1rem;
            max-height: 16rem;
            max-width: 42rem;
        }
    </style>
@endpush
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.addEventListener('paste', function (evt) {
                const clipboardItems = evt.clipboardData.items;
                const items = [].slice.call(clipboardItems).filter(function (item) {
                    // Filter the image items only
                    return item.type.indexOf('image') !== -1;
                });
                if (items.length === 0) {
                    return;
                }

                const item = items[0];
                const blob = item.getAsFile();

                const imageEle = document.getElementById('preview');
                imageEle.src = URL.createObjectURL(blob);

                const fileInput = document.getElementById("document_attachment_doc");
                fileInput.files = evt.clipboardData.files;
            });
        });
    </script>
@endpush
