@extends('layouts.admin_layout')

@section('title', 'Результаты')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <a href="{{ route('theme.tests', $test->theme['id']) }}" class="btn btn-secondary">Назад</a>
                </div>
                <div class="col-sm-6">
                    <h1>Результаты теста по теме "{{$test->theme->title}}"</h1>
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
                            Имя
                        </th>
                        <th>
                            Результат
                        </th>
                        <th>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $user->name }}
                            </td>
                            <td>
                                {{ $user->passed($test) }}
                            </td>
                            <td>
                                <a class="btn btn-info btn-sm" href="{{ route('test.user.attempts', [$test['id'], $user['id']]) }}">
                                    <i class="fas fa-list">
                                    </i> Попытки
                                </a>
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
