@extends('layouts.admin_layout')

@section('title', 'Видео')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-1">
                    <a href="{{ route('chapter.themes', $theme->chapter->id)}}" class="btn btn-secondary">Назад</a>
                </div>
                <div class="col-sm-6">
                    <h1>Видео в теме "{{$theme->title}}"</h1>
                </div>
                <div class="col-sm-2">
                    
                    <a href="{{ route('theme.video.create', $theme['id'])}}" class="btn btn-success float-right">Добавить
                        видео</a>
                </div>
                <div class="col-sm-3">
                        <button type="button" class="btn btn-info float-right mr-2" data-toggle="modal"
                    data-target="#modal-inst-video">Инструкция по загрузке видео</button>
                </div>
            </div>
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session('success') }}
                </div>
            @endif
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Название
                        </th>
                        <th>
                            Ссылка
                        </th>
                        <th>
                            Секция
                        </th>
                        <th>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($theme->files->where('type', 'video') as $file)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $file->title }}
                            </td>
                            <td>
                                <a href="{{ $file->url }}">{{ $file->fileName }}</a>
                            </td>
                            <td>
                                {{ $file->section->title }}
                            </td>
                            <td class="project-actions text-right">
                                <a class="btn btn-primary btn-sm"
                                   href="{{ route('theme.video.edit', [$theme['id'], $file['id']]) }}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                </a>
                                <form action="{{ route('file.destroy', $file['id']) }}" method="POST"
                                      style="display: inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                        <i class="fas fa-trash">
                                        </i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->

    <div class="modal fade" id="modal-inst-video">
        <div class="modal-dialog" style="max-width:80%">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="color: #333">
                        Инструкция по добавлению видео
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
                        <source src="/video/video_instruction.mp4">
                        Извините, но ваш браузер не поддерживает воспроизведение данного видео, вы можете <a href="/video/video_instruction.mp4">скачать его</a>
                    </video>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
