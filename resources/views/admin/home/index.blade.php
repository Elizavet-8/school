@extends('layouts.admin_layout')

@section('title', 'Главная')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Статистика</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $users_count }}</h3>

                            <p>Пользователи</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                        <a href="/admin/user" class="small-box-footer">Перейти <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $users_attempts }}<sup style="font-size: 20px"></sup></h3>

                            <p>Попытки пользователей</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="/admin/user" class="small-box-footer">Перейти <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>Заполненность </h3>
                            <p>курсов, модулей, тем</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <form method="get" action="{{ route('course.export') }}">
                            @csrf
                            <button type="submit" class="small-box-footer"
                                    style="border: none;
                                    background-color: rgba(0,0,0,.1);
                                    color: rgba(255,255,255,.8);
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    width: 100%;
                                    padding: 3px 0;
                                    position: relative;
                                    text-align: center;
                                    text-decoration: none;
                                    z-index: 10;">
                                Скачать <i class="fas fa-arrow-circle-right"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
