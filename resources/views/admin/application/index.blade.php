@extends('layouts.admin_layout')

@section('title', 'Заявки')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Заявки</h1>
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
                        @sortablelink('name', 'ФИО')
                    </th>
                    <th>
                        @sortablelink('place_of_work', 'Сфера деятельности')
                    </th>
                    <th>
                        @sortablelink('city', 'Город')
                    </th>
                    <th>
                        @sortablelink('email', 'e-mail')
                    </th>
                    <th>
                        @sortablelink('status', 'Статус')
                    </th>
                    <th>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applications as $application)
                <tr>
                    <td>
                        {{ $loop->iteration }}
                    </td>
                    <td>
                        {{ $application->name }}
                    </td>
                    <td>
                        {{ $application->place_of_work }}
                    </td>
                    <td>
                        {{ $application->city }}
                    </td>
                    <td>
                        {{ $application->email }}
                    </td>
                    <td>
                        {{ $application->status }}
                    </td>
                    <td class="project-actions text-right">
                        @if ($application->status == 'новая')
                        <a class="btn btn-info btn-sm" href="{{ route('application.postpone', $application['id']) }}">
                            <i class="fas fa-clock"></i>
                            Отложить
                        </a>
                        @endif
                        @if ($application->status == 'новая' || $application->status == 'отложена')
                        <a class="btn btn-success btn-sm" href="{{ route('application.accept', $application['id']) }}">
                            <i class="fas fa-check">
                            </i>
                            Принять
                        </a>
                        <a class="btn btn-warning btn-sm" href="{{ route('application.deny', $application['id']) }}">
                            <i class="fas fa-times">
                            </i>
                            Отказать
                        </a>
                        @endif
                        @if ($application->status == 'не принята')
                        <a class="btn btn-info btn-sm" href="#">
                            <i class="fas fa-eye">
                            </i>
                            Причина отказа
                        </a>
                        @endif
                        <form action="{{ route('application.destroy', $application['id']) }}" method="POST"
                            style="display: inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                <i class="fas fa-trash">
                                </i>
                                Удалить
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
    <div class="w100 d-flex justify-content-center">
        {{ $applications->links() }}
    </div>
  </section>
  <!-- /.content -->
@endsection
