@extends('layouts.admin_layout')

@section('title', 'Расписание')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Добавление урока</h1>
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
        <form method="post" action="{{ route('course.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
                <div class="col-12">
                    <a href="{{ route('course.index')}}" class="btn btn-secondary">Назад</a>
                    <input type="submit" value="Добавить курс" class="btn btn-success float-right">
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
                                <label for="inputStatus2">Курс</label>
                                <select name="course_id" id="inputStatus2" class="form-control custom-select">
                                    @foreach ($courses as $course)
                                    <option value="{{$course->id}}">{{$course->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputStatus">Учитель</label>
                                <select 
                                @if(auth()->user()->hasRole('teacher') && !auth()->user()->hasRole('admin'))
                                disabled 
                                @endif
                                name="user_id" id="inputStatus" class="form-control custom-select">
                                    @if(auth()->user()->hasRole('teacher') && !auth()->user()->hasRole('admin'))
                                    <option selected value="{{auth()->user()->id}}">{{auth()->user()->name}}</option>
                                    @endif
                                    @foreach ($teachers as $teacher)
                                    <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if(auth()->user()->hasRole('teacher') && !auth()->user()->hasRole('admin'))
                            <input value="{{auth()->user()->id}}" name="user_id" type="hidden">
                            @endif
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
