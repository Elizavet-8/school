@extends('layouts.admin_layout')

@section('title', 'Курсы')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Редактирование курса</h1>
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
        <form method="post" action="{{ route('course.update', $course['id']) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row mb-3">
                <div class="col-12">
                    <a href="{{ route('course.index')}}" class="btn btn-secondary">Назад</a>
                    <input type="submit" value="Сохранить изменения" class="btn btn-success float-right">
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
                                <input value="{{ $course['title'] }}" name="title" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="inputStatus">Учитель</label>
                                @if(auth()->user()->hasRole('teacher') && !auth()->user()->hasRole('admin'))
                                <div>{{$course->user->name}}</div>
                                <input id="inputStatus" readonly style="visibility: hidden" value="{{ $course['user_id'] }}" name="user_id" type="text" class="form-control">
                                @else
                                <select 
                                 name="user_id" id="inputStatus" class="form-control custom-select">
                                    @foreach ($teachers as $teacher)
                                    <option @if ($teacher->id == $course['user_id'])
                                        selected
                                    @endif value="{{$teacher->id}}">{{$teacher->name}}</option>
                                    @endforeach
                                </select>
                                @endif
                            </div>
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
                            @if($course['img_url'])
                            <img style="height: 100px; width: 100px; object-fit: cover" src="{{$course['img_url']}}" alt="Course image">
                            @endif
                            <div class="form-group">
                                <label>Изображение</label>
                                <input style="height: 46px;" value="{{ old('image') }}" name="image" type="file" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Количество часов</label>
                                <input value="{{ $course['hours'] }}" name="hours" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Описание</label>
                                <textarea name="description" type="text" class="form-control">{{ $course['description'] }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="inputStatus2">Учебные заведения</label>
                                <select multiple name="schools[]" id="inputStatus2" class="form-control custom-select">
                                    @foreach ($schools as $school)
                                    <option @if ($course->schools->contains($school->id))
                                        selected
                                    @endif value="{{$school->id}}">{{$school->title}}</option> 
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputStatus3">Учебные программы</label>
                                <select multiple name="curricula[]" id="inputStatus3" class="form-control custom-select">
                                    @foreach ($curricula as $curriculum)
                                    <option @if ($course->curricula->contains($curriculum->id))
                                        selected
                                    @endif value="{{$curriculum->id}}">{{$curriculum->title}}</option> 
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Класс</label>
                                <input value="{{ $course['grade'] }}" name="grade" type="text"
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
