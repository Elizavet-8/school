@extends('layouts.admin_layout')

@section('title', 'Курсы')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Добавление курса</h1>
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
                <div class="col-md-6">
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
                                <label>Название</label>
                                <input value="{{ old('title') }}" name="title" type="text" class="form-control">
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
                <div class="col-md-6">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Опциональные параметры</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Изображение</label>
                                <input style="height: 46px;" value="{{ old('image') }}" name="image" type="file" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Количество часов</label>
                                <input value="{{ old('hours') }}" name="hours" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Описание</label>
                                <textarea name="city" type="text" class="form-control">{{ old('description') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="inputStatus2">Учебные заведения</label>
                                <select multiple name="schools[]" id="inputStatus2" class="form-control custom-select">
                                    @foreach ($schools as $school)
                                    <option value="{{$school->id}}">{{$school->title}}</option> 
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputStatus3">Учебные программы</label>
                                <select multiple name="curricula[]" id="inputStatus3" class="form-control custom-select">
                                    @foreach ($curricula as $curriculum)
                                    <option value="{{$curriculum->id}}">{{$curriculum->title}}</option> 
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Класс</label>
                                <input value="{{ old('grade') }}" name="grade" type="text"
                                       class="form-control">
                            </div>
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
