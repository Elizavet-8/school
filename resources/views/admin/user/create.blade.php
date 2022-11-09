@extends('layouts.admin_layout')

@section('title', 'Пользователи')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Добавление пользователя</h1>
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
        <form method="post" action="{{ route('user.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
                <div class="col-12">
                    <a href="{{ route('user.index')}}" class="btn btn-secondary">Назад</a>
                    <input type="submit" value="Добавить пользователя" class="btn btn-success float-right">
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
                                <label>ФИО</label>
                                <input value="{{ old('name') }}" name="name" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>e-mail</label>
                                <input value="{{ old('email') }}" name="email" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Пароль</label>
                                <input id="password_input" name="password" class="form-control">
                                <button type="button" onclick="generatePassword()" id="generate_password" class="btn btn-success float-right mt-2">Сгенерировать пароль</button>
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
                            <div class="form-group">
                                <label>Аватар</label>
                                <input style="height: 46px;" value="{{ old('image') }}" name="image" type="file"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Город</label>
                                <input value="{{ old('city') }}" name="city" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Класс</label>
                                <input value="{{ old('grade') }}" name="grade" type="text"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="inputStatus">Пол</label>
                                <select name="sex" id="inputStatus" class="form-control custom-select">
                                    <option selected>не указан</option>
                                    <option>мужской</option>
                                    <option>женский</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputStatus2">Учебное заведение</label>
                                <select name="school_id" id="inputStatus2" class="form-control custom-select">
                                    <option value="" selected>не указано</option>
                                    @foreach ($schools as $school)
                                    <option value="{{$school->id}}">{{$school->title}}</option> 
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Дата рождения</label>
                                <input value="{{ old('birth') }}" name="birth" type="date" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Роли</label><br>
                                @foreach($roles as $role)
                                    <div class="form-check form-check-inline">
                                        <input name="roles[]" class="form-check-input" type="checkbox"
                                               id="inlineCheckbox{{$role->id}}" value={{$role->name}}>
                                        <label class="form-check-label"
                                               for="inlineCheckbox{{$role->id}}">{{$role->name}}</label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <label>Разрешения</label><br>
                                @foreach($permissions as $permission)
                                    <div class="form-check form-check-inline">
                                        <input name="permissions[]" class="form-check-input" type="checkbox"
                                            id="permissionsCheckbox{{$permission->id}}" value={{$permission->name}}>
                                        <label class="form-check-label"
                                            for="permissionsCheckbox{{$permission->id}}">{{$permission->name}}</label>
                                    </div>
                                @endforeach
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
