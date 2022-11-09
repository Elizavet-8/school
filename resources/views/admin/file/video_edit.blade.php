@extends('layouts.admin_layout')

@section('title', 'Видео')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Изменение видео {{$file['title']}} в теме "{{$theme->title}}"</h1>
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
        <form method="post" action="{{ route('theme.video.update', $file['id']) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row mb-3">
                <div class="col-12">
                    <a href="{{ route('theme.files', $theme['id']) }}" class="btn btn-secondary">Назад</a>
                    <input type="submit" value="Сохранить видео" class="btn btn-success float-right">
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
                                <input value="{{ $file['title'] }}" name="title" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="inputStatus2">Секция</label>
                                <select name="section_id" id="inputStatus2" class="form-control custom-select">
                                    @foreach ($sections as $section)
                                    <option @if ($section->id == $file['section_id'])
                                        selected
                                    @endif value="{{$section->id}}">{{$section->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Ссылка</label>
                                <input value="{{ $file['url'] }}" name="file" type="text" class="form-control">
                                <small>
                                    При вставке короткой ссылки необходимо изменить с <b>"https://youtu.be/"</b> на <b>"https://www.youtube.com/embed/"</b><br>
                                    <b>Пример:</b> <b>"https://youtu.be/KqacjO84ME0"</b> необходимо изменить на <b>"https://www.youtube.com/embed/KqacjO84ME0"</b>
                                </small>
                            </div>
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
