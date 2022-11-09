@extends('layouts.admin_layout')

@section('title', 'Тесты')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Добавление теста тему "{{$theme->title}}"</h1>
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
        <form method="post" action="{{ route('test.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
                <div class="col-12" style="display: flex;
                justify-content: space-between;">
                    <a href="{{ route('theme.tests', $theme['id']) }}" class="btn btn-secondary">Назад</a>
                    <button type="button" class="btn btn-info" data-toggle="modal"
                    data-target="#modal-inst-test">Инструкция по добавлению теста</button>
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
                                <test-admin-component
                                    :theme="{{$theme}}"
                                ></test-admin-component>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </form>
    </section>
    <!-- /.content -->

    <div class="modal fade" id="modal-inst-test">
        <div class="modal-dialog" style="max-width:80%">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="color: #333">
                        Инструкция по добавлению теста
                    </h4>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <video width="100%" controls="controls">
                        <source src="/video/test_instruction.mp4">
                        Извините, но ваш браузер не поддерживает воспроизведение данного видео, вы можете <a href="/video/test_instruction.mp4">скачать его</a>
                    </video>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
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


                const fileInput = document.querySelector(".document_attachment_doc");
                fileInput.files = evt.clipboardData.files;
            });
        });

    </script>
@endpush
