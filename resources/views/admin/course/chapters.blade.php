@extends('layouts.admin_layout')

@section('title', 'Модули')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <a href="{{ route('course.index')}}" class="btn btn-secondary">Назад</a>
                </div>
                <div class="col-sm-6">
                    <h1>Модули курса "{{$course->title}}"</h1>
                </div>
                <div class="col-sm-3">
                    <a href="{{ route('course.chapters.create', $course['id'])}}" class="btn btn-success float-right">Добавить
                        модуль</a>
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
                            Темы
                        </th>
                        <th>
                            Процент заполнения
                        </th>
                        <th>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($course->chapters as $chapter)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td style="max-width: 300px">
                                    {{ $chapter->title }}
                                </td>
                                <td>
                                    {{ $chapter->order }}
                                </td>
                                <td>
                                    {{ $chapter->themes->count() }}
                                </td>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar
                                    @if ($chapter->percent() == 100)
                                    bg-success
                                    @elseif($chapter->percent() > 50)
                                    bg-warning
                                    @else
                                    bg-danger
                                    @endif
                                        " style="width: {{$chapter->percent()}}%"></div>
                                    </div>
                                    <span class="badge
                                @if ($chapter->percent() == 100)
                                bg-success
                                @elseif($chapter->percent() > 50)
                                bg-warning
                                @else
                                bg-danger
                                @endif
                                ">{{ $chapter->percent() }}%</span>
                                </td>
                                <td class="project-actions text-right">
                                    <a class="btn btn-info btn-sm" href="{{ route('chapter.themes', $chapter['id']) }}">
                                        <i class="fas fa-list">
                                        </i> Темы
                                    </a>
                                    <a class="btn btn-primary btn-sm"
                                       href="{{ route('course.chapters.edit', [$course['id'], $chapter['id']]) }}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                    </a>
                                    <form action="{{ route('chapter.destroy', $chapter['id']) }}" method="POST"
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
@endsection
