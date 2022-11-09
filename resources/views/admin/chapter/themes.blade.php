@extends('layouts.admin_layout')

@section('title', 'Темы')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <a href="{{ route('course.chapters', $chapter->course->id)}}" class="btn btn-secondary">Назад</a>
                </div>
                <div class="col-sm-6">
                    <h1>Темы модуля "{{$chapter->title}}"</h1>
                </div>
                <div class="col-sm-3">
                    <a href="{{ route('chapter.themes.create', $chapter['id'])}}" class="btn btn-success float-right">Добавить
                        тему</a>
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
                            Номер
                        </th>
                        <th>
                            Тесты
                        </th>
                        <th>
                            Материалы
                        </th>
                        <th>
                            Процент заполнения
                        </th>
                        <th>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($chapter->themes as $theme)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $theme->title }}
                            </td>
                            <td>
                                {{ $theme->order }}
                            </td>
                            <td>
                                {{ $theme->tests->count() }}
                            </td>
                            <td>
                                {{ $theme->files->count() }}
                            </td>
                            <td>
                                <div class="progress progress-xs">
                                    <div class="progress-bar
                                    @if ($theme->percent() == 100)
                                    bg-success
                                    @elseif($theme->percent() > 50)
                                    bg-warning
                                    @else
                                    bg-danger
                                    @endif
                                        " style="width: {{$theme->percent()}}%"></div>
                                </div>
                                <span class="badge
                                @if ($theme->percent() == 100)
                                bg-success
                                @elseif($theme->percent() > 50)
                                bg-warning
                                @else
                                bg-danger
                                @endif
                                ">{{ $theme->percent() }}%</span>
                            </td>
                            <td class="project-actions text-right">
                                <a class="btn btn-info btn-sm mb-1" href="{{ route('theme.videos', $theme['id']) }}">
                                    <i class="fas fa-list">
                                    </i> Видео
                                </a>
                                <a class="btn btn-info btn-sm mb-1" href="{{ route('theme.files', $theme['id']) }}">
                                    <i class="fas fa-list">
                                    </i> Материалы
                                </a>
                                <a class="btn btn-info btn-sm mb-1" href="{{ route('theme.tests', $theme['id']) }}">
                                    <i class="fas fa-list">
                                    </i> Тесты
                                </a>
                                <a class="btn btn-info btn-sm mb-1"
                                   href="{{ route('theme.practicals', $theme['id']) }}">
                                    <i class="fas fa-list">
                                    </i> Практические
                                </a>
                                <a class="btn btn-info btn-sm mb-1" href="{{ route('theme.comments',  $theme['id']) }}">
                                    <i class="fas fa-list">
                                    </i> Комментарии
                                </a>
                                <a class="btn btn-primary btn-sm mb-1"
                                   href="{{ route('chapter.themes.edit', [$chapter['id'], $theme['id']]) }}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                </a>
                                <form action="{{ route('theme.destroy', $theme['id']) }}" method="POST"
                                      style="display: inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class=" mb-1 btn btn-danger btn-sm delete-btn">
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
@endsection
