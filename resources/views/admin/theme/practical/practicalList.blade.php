@extends('layouts.admin_layout')

@section('title', 'Практические работы')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-1">
                    <a href="{{ route('chapter.themes', $theme->chapter->id)}}" class="btn btn-secondary">Назад</a>
                </div>
                <div class="col-sm-6">
                    <h1>Практические работы "{{$theme->title}}"</h1>
                </div>
                <div class="col-sm-2">

                    <a href="{{ route('theme.practical.create', $theme['id'])}}" class="btn btn-success float-right">Добавить
                        практическую работу</a>
                </div>
                <div class="col-sm-3">
                    <button type="button" class="btn btn-info float-right mr-2" data-toggle="modal"
                            data-target="#modal-inst-text">Инструкция по работе с практическими
                    </button>
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
                            Название
                        </th>
                        <th>
                            Оценка практической учеником
                        </th>
                        <th>
                            Секция
                        </th>
                        <th>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($theme->practicals as $practical)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $practical->title }}
                                @if($practical->not_read_comments!=0)
                                    <span class="badge badge-danger">{{$practical->not_read_comments}}</span>
                                @endif
                            </td>
                            @isset($practical->feedbacks)
                                <td>
                                    @foreach($practical->feedbacks as $feedback)
                                        {{ $feedback->user->name }}: {{ $feedback->body }};
                                    @endforeach
                                </td>
                            @endisset
                            <td>
                                {{ $practical->section->title }}
                            </td>
                            <td class="project-actions text-right">
                                <a class="btn btn-info btn-sm"
                                   href="{{ route('practical.comments', [$theme['id'], $practical['id']]) }}">
                                    <i class="fas fa-list">
                                    </i> Комментарии
                                </a>
                                <a class="btn btn-primary btn-sm"
                                   href="{{ route('theme.practical.edit', [$theme['id'], $practical['id']]) }}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                </a>
                                <form action="{{ route('practical.delete', $practical['id']) }}" method="POST"
                                      style="display: inline-block">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                        <i class="fas fa-trash">
                                        </i>
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
    </section>
    <!-- /.content -->
    <div class="modal fade" id="modal-inst-text">
        <div class="modal-dialog" style="max-width:80%">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="color: #333">
                        Инструкция по работе с практическими
                    </h4>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <h3>
                                1. Как добавить практическую?
                            </h3>
                            <p class="text-justify">
                                <b>1.1</b> Нажать на кнопку <b>"Добавить практическую"</b>.
                            </p>
                            <p class="text-justify">
                                <b>1.2</b> Заполнить все обязательные поля в блоке <b>"Обязательные параметры"</b> и
                                добавить
                                решение
                                практической в блоке <b>"Правильное решение практической"</b>. Если решение
                                подразумевает
                                наличие файла (необязательно), то дабавить его. При необходимости запольнить
                                необязательные поля в блоке <b>"Опциональные параметры"</b>. Поле <b>"Изменить
                                    статут"</b> значит
                                открыть практическую для общего решения (по умолчанию практическая будет персональная).
                            </p>
                            <p class="text-justify">
                                <b>1.3</b> После заполнения всех нужных полей нажать на кнопку <b>"Добавить
                                    практическую"</b>.
                            </p>
                        </li>
                        <li class="list-group-item">
                            <h3>
                                2. Как проверить практическую?
                            </h3>
                            <p class="text-justify">
                                <b>2.1</b> Нажать на кнопку <b>"Комментарии"</b>. Решениие от учеников со всеми
                                приложенными
                                файлами и картинками будет представлено в виде карточек в указанием имени ученика.
                                <img src="" alt="">
                            </p>
                            <div class="text-justify">
                                <b>2.2</b> <span>Далее нужно выполнить вледующие дейсвия:</span>
                                <ul>
                                    <li>
                                        Отметить статус практической ("принята", "отправлена на доработку", "отклонена")
                                        в блоке <b>"1. Отметьте статус практической"</b>.
                                        При желании можно добавить обоснование выбранного статуса.
                                    </li>
                                    <li>
                                        При необходимости ответить ученику в комментариях в блоке <b>"2. Ответить"</b>,
                                        в
                                        котором
                                        можно прикрепить файл или картинку.
                                    </li>
                                    <li>
                                        Если нужно, то можно отправить ученику правильное решение практической в блоке
                                        <b>"3. Отправить правильное решение</b>".
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>


                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
