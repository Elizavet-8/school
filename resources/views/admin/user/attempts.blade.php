@extends('layouts.admin_layout')

@section('title', 'Результаты')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <a href="{{ route('user.course.tests', [$user['id'], $test->theme->chapter->course['id']]) }}" class="btn btn-secondary">Назад</a>
                </div>
                <div class="col-sm-6">
                    <h1>Попытки пользователя {{$user->name}} теста по теме "{{$test->theme->title}}"</h1>
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
                            Правильных ответов
                        </th>
                        <th>
                            Результат
                        </th>
                        <th>Дата и время</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($attempts as $attempt)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $attempt->correct }}/{{ $attempt->questions }}
                            </td>
                            <td>
                                {{ $attempt->is_passed ? "сдан" : "не сдан" }}
                            </td>
                            <td>
                                {{ $attempt->created_at }}
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
