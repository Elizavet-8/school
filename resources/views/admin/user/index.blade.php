@extends('layouts.admin_layout')

@section('title', 'Пользователи')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Пользователи</h1>
        </div>
        <div class="col-sm-6">
            <a href="{{ route('user.create')}}" class="btn btn-success float-right">Добавить пользователя</a>
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
  <users></users>
  <!-- /.content -->
@endsection
