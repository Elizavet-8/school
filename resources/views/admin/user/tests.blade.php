@extends('layouts.admin_layout')

@section('title', 'Тесты')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <a href="/admin/user/{{$user->id}}/courses" class="btn btn-secondary">Назад</a>
                </div>
                <div class="col-sm-6">
                    <h1>Тесты курса "{{$course->title}}" пройденные пользователем {{$user->name}}</h1>
                </div>
            </div>
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
                            Тест
                        </th>
                        <th>
                            Раздел
                        </th>
                        <th>
                            Тема
                        </th>
                        <th>
                            Модуль
                        </th>
                        <th>
                            Результат
                        </th>
                        <th>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($tests as $test)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                Тест {{$test->order}}. {{$test->title}}
                            </td>
                            <td>
                                {{$test->section->title}}
                            </td>
                            <td>
                                {{$test->theme->order}}. {{ $test->theme->title }}
                            </td>
                            <td>
                                {{$test->theme->chapter->order}}. {{ $test->theme->chapter->title }} 
                            </td>
                            <td>
                                {{ $user->passed($test) }}
                            </td>
                            <td>
                                <td>
                                    <a class="btn btn-info btn-sm" href="{{ route('user.test.attempts', [$user['id'], $test['id']]) }}">
                                        <i class="fas fa-list">
                                        </i> Попытки
                                    </a>
                                </td>
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
