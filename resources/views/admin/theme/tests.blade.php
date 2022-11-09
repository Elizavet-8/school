@extends('layouts.admin_layout')

@section('title', 'Тесты')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <a href="{{ route('chapter.themes', $theme->chapter->id)}}" class="btn btn-secondary">Назад</a>
                </div>
                <div class="col-sm-6">
                    <h1>Тесты темы "{{$theme->title}}"</h1>
                </div>
                <div class="col-sm-3">
                    <a href="{{ route('theme.tests.create', $theme['id'])}}" class="btn btn-success float-right">Добавить
                        тест</a>
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
                            Продолжительность (мин)
                        </th>
                        <th>
                            Минимальное количество верных ответов
                        </th>
                        <th>
                            Вопросы
                        </th>
                        <th>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($theme->tests as $test)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $test->title }}
                            </td>
                            <td>
                                {{ $test->minutes }}
                            </td>
                            <td>
                                {{ $test->min_correct }}
                            </td>
                            <td>
                                {{ $test->questions->count() }}
                            </td>
                            <td class="project-actions text-right">
                                <a class="btn btn-info btn-sm" href="{{ route('test.results', $test['id']) }}">
                                    <i class="fas fa-list">
                                    </i> Результаты
                                </a>
                                <a class="btn btn-primary btn-sm"
                                   href="{{ route('theme.tests.edit', [$theme['id'], $test['id']]) }}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                </a>
                                <form action="{{ route('test.destroy', $test['id']) }}" method="POST"
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
