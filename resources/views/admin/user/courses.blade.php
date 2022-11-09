@extends('layouts.admin_layout')

@section('title', 'Курсы')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <a href="/admin/user" class="btn btn-secondary">Назад</a>
                </div>
                <div class="col-sm-6">
                    <h1>Курсы доступные пользователю {{ $user->name }}</h1>
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
                            @sortablelink('title', 'Название')
                        </th>
                        <th>
                            @sortablelink('user_id', 'Учитель')
                        </th>
                        <th>
                            Модули
                        </th>
                        <th>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($courses as $course)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td style="max-width: 300px">
                                {{ $course->title }}
                            </td>
                            <td>
                                {{ $course->user->name }}
                            </td>
                            <td>
                                {{ $course->chapters->count() }}
                            </td>
                            <td class="project-actions text-right">
                                <a class="btn btn-info btn-sm" href="{{ route('user.course.tests', [$user['id'], $course['id']]) }}">
                                    <i class="fas fa-check-square"></i> Тесты
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
        {{-- <div class="w100 d-flex justify-content-center">
            {{ $courses->links() }}
        </div> --}}
    </section>
    <!-- /.content -->
@endsection
