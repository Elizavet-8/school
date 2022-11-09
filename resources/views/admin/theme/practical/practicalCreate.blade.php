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
        <form method="post" action="{{ route('theme.practical.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
                <div class="col-12">
                    <a href="{{ route('theme.practicals', $theme['id']) }}" class="btn btn-secondary">Назад</a>
                    <input type="submit" value="Добавить практическую" class="btn btn-success float-right">
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
                            <input value="{{$theme->id}}" name="theme_id" type="hidden">
                            <div class="form-group">
                                <label>Цель работы</label>
                                <textarea value="" rows="5" name="purpose" type="text"
                                          class="form-control">{{ old('purpose') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Задача</label>
                                <textarea value="" id="task" rows="5" name="task" type="text"
                                          class="form-control">{{ old('task') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Рекомендации по выполнению:</label>
                                <textarea value="" rows="5" name="recommendations" type="text"
                                          class="form-control">{{ old('recommendations') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Критерии оценки</label>
                                <textarea value="" rows="5" name="criteria" type="text"
                                          class="form-control">{{ old('criteria') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Как сдать работу</label>
                                <textarea value="" rows="5" name="howtosend" type="text"
                                          class="form-control">{{ old('howtosend') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Опциональные параметры</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <practical-status></practical-status>
                            <div class="form-group">
                                <label>Файл с описанием задачи</label>
                                <input style="height: 46px;" name="file" type="file"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Ссылка на дополнительные ресурсы</label>
                                <input style="height: 46px;" value="{{ old('link') }}" name="link" type="text"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Картинка с описанием задачи(Ctrl + V)</label>
                                <input style="height: 46px;" name="image" type="file"
                                       class="form-control" id="document_attachment_doc">
                            </div>
                            <img class="preview" id="preview" src=""/>
                        </div>
                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Правильное решение практической</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Решение</label>
                                <textarea id="correct" name="correct" type="text" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Файл</label>
                                <input style="height: 46px;" name="correct_file" type="file"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </form>
    </section>
    <!-- /.content -->
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('plugin/summernote/summernote-bs4.min.css') }}">
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
    <script src="{{ asset('plugin/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('plugin/summernote/lang/summernote-ru-RU.min.js') }}"></script>
    <script>
        $(function () {
            $('#task').summernote({
                placeholder: 'Введите текст',
                tabsize: 2,
                height: 200,
                lang: 'ru-RU',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ol', 'ul', 'paragraph', 'height']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
                ]
            });
            $('#correct').summernote({
                placeholder: 'Введите текст',
                tabsize: 2,
                height: 200,
                lang: 'ru-RU',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ol', 'ul', 'paragraph', 'height']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>
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
