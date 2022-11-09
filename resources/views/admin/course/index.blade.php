@extends('layouts.admin_layout')

@section('title', 'Курсы')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Курсы</h1>
                </div>

                <div class="col-sm-6">
                    @can('создание курсов')
                        <a href="{{ route('course.create')}}" class="btn btn-success float-right">Добавить курс</a>
                    @endcan
                    <a target="_blank" href="/instructions/teacher_instruction.pdf"
                       class="btn btn-info float-right mr-2">Инструкция учителя по работе с системой</a>
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
        <div class="row mb-2">
            <div class="col-2">
                <label for="myselect">На странице</label>
                <form action="{{ route('course.index') }}" method="get">
                    <select class="form-control custom-select" name="per_page" id="myselect"
                            onchange="this.form.submit()">

                        <option @if ($per_page == 20)
                                    selected
                            @endif>20
                        </option>
                        <option @if ($per_page == 50)
                                    selected
                            @endif>50
                        </option>
                        <option @if ($per_page == 100)
                                    selected
                            @endif>100
                        </option>
                    </select>
                </form>
            </div>
            <div class="col-2">
                <label for="search_teachers">Поиск учителей</label>
                <form action="{{ route('search.teachers') }}" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" id="search_teachers" name="search_teachers"
                               placeholder="Все">
                        <button type="submit" class="input-group-text"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="col-2">
                <label for="search_courses">Поиск курсов</label>
                <form action="{{ route('search.courses') }}" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" id="search_courses" name="search_courses"
                               placeholder="Все">
                        <button type="submit" class="input-group-text"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Default box -->
        @if (count($courses))
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
                                Процент заполнения
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

                                    @if($course->not_read_course_comments!=0)
                                        <span class="badge badge-danger">{{$course->not_read_course_comments}}</span>
                                    @endif

                                </td>
                                <td>
                                    {{ $course->user->name }}
                                </td>
                                <td>
                                    {{ $course->chapters->count() }}
                                </td>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar
                                    @if ($course->percent() == 100)
                                            bg-success
@elseif($course->percent() > 50)
                                            bg-warning
@else
                                            bg-danger
@endif
                                            " style="width: {{$course->percent()}}%"></div>
                                    </div>
                                    <span class="badge
                                @if ($course->percent() == 100)
                                        bg-success
@elseif($course->percent() > 50)
                                        bg-warning
@else
                                        bg-danger
@endif
                                        ">{{ $course->percent() }}%</span>
                                </td>
                                <td class="project-actions text-right">
                                    @if(auth()->user()->id  ==  $course->user->id || auth()->user()->hasRole('admin'))
                                        <a class="btn btn-info btn-sm"
                                           href="{{ route('course.chapters', $course->course_id??$course->id) }}">
                                            <i class="fas fa-list">
                                            </i> Модули
                                        </a>
                                        @can('редактирование курсов')
                                            <a class="btn btn-primary btn-sm"
                                               href="{{ route('course.edit', $course->course_id??$course->id) }}">
                                                <i class="fas fa-pencil-alt">
                                                </i>
                                            </a>
                                        @endcan
                                        @can('удаление курсов')
                                            <form
                                                action="{{ route('course.destroy', $course->course_id??$course->id) }}"
                                                method="POST"
                                                style="display: inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                </button>
                                            </form>
                                        @endcan
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        @else
            <h3 style="margin: 15px 0;">По запросу ничего не найдено...</h3>
        @endif
        <div class="w100 d-flex justify-content-center">
            {{ $courses->links() }}
        </div>
    </section>
    <!-- /.content -->
@endsection
