@extends('layouts.admin_layout')

@section('title', 'Пользователи')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Отказ пользователю</h1>
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
        <form method="post" action="{{ route('application.send.deny') }}">
            @csrf
            <input type="hidden" name="application_id" value="{{ $application['id'] }}">
            <div class="row mb-3">
                <div class="col-12">
                    <a href="{{ route('application.index')}}" class="btn btn-secondary">Назад</a>
                    <input type="submit" value="Отправить отказ" class="btn btn-danger float-right">
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
                                <label>email</label>
                                <input readonly value="{{ $application['email'] }}" name="email" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Текст письма</label>
                                <textarea name="reason" type="text" class="form-control"></textarea>
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
