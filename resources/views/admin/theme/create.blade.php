@extends('layouts.admin_layout')

@section('title', 'Темы')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Добавление темы модуля "{{$chapter->title}}"</h1>
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
        <form method="post" action="{{ route('theme.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
                <div class="col-12">
                    <a href="{{ route('chapter.themes', $chapter['id']) }}" class="btn btn-secondary">Назад</a>
                    <input type="submit" value="Добавить тему" class="btn btn-success float-right">
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
                            <input value="{{$chapter->id}}" name="chapter_id" type="hidden">
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
                                <label>Номер</label>
                                <input value="{{ old('order') }}" name="order" type="number" class="form-control">
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
