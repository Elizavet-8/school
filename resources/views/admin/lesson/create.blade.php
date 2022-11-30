@extends('layouts.admin_layout')

@section('title', 'Расписание')

@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid" id="calendar">
        <!-- Small boxes (Stat box) -->

          <lesson-component
          :date="'{{ $date }}'"
          :courses="{{ $courses }}"
          ></lesson-component>

        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection