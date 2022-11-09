@extends('layouts.admin_layout')

@section('title', 'Модули')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Добавление комментариев "{{$practical->title}}"</h1>
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
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ session('success') }}
            </div>
        @endif
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row mb-3">
            <div class="col-12">
                <a href="{{ route('theme.practicals', $theme['id']) }}" class="btn btn-secondary">Назад</a>
            </div>
        </div>
        <div class="row">
            @if(auth()->user()->is_admin)
                @forelse($notifications as $notification)
                    <div class="alert alert-success" role="alert">
                        [{{ $notification->created_at }}] has just registered.
                    </div>

                    @if($loop->last)
                        <a href="#" id="mark-all">
                            Mark all as read
                        </a>
                    @endif
                @empty
                    There are no new notifications
                @endforelse
            @endif

            @foreach($practical->comments as $comment)
                <div class="col-md-6">
                    <div class="card">
                        @if($comment['image'])
                            <img style="object-fit: cover; width: 100%; height: 25rem; object-fit: cover;"
                                 src="{{ $comment['image']}}">
                        @endif
                        <div class="card-body">
                            <div class="row" style="margin: 0; align-items: center; justify-content: space-between;">
                                <h5 class="card-title">От {{ $comment->user->name }}</h5>
                                <div class="card-text"><small
                                        class="text-muted">{{ $comment->DateAsCorbon->diffForHumans() }}</small></div>
                            </div>
                            <p class="card-text">{!! $comment->body !!}</p>
                            @if($comment['file'])
                                <a class="card-link"
                                   href="{{ $comment['file'] }}" download="">Документ</a>
                            @endif
                            <h5 class="card-header"
                                style="padding-left: 0; padding-right: 0; margin: 25px 0 15px; font-weight: 600;">Ваши
                                действия:</h5>
                            <form method="post"
                                  action="{{ route('theme.practical.correct', [$theme['id'], $practical['id']]) }}">
                                @csrf
                                <div class="form-group">
                                    <practical-correct></practical-correct>
                                    <label>Дополнительное описание
                                        статуса(необязательно)</label>
                                    <input type="text" name="body" class="form-control"
                                           placeholder="Ответить"/>
                                    <input type="hidden" name="practical_id"
                                           value="{{ $practical['id'] }}"/>
                                    <input type="hidden" name="to_user_id"
                                           value="{{ $comment->user->id }}"/>
                                </div>
                                <button type="submit" class="btn btn-primary">Отправить</button>
                            </form>
                            @foreach($practical->corrects as $correct)
                                @if('принята' == $correct->correct)
                                    <div class="alert alert-success" role="alert">
                                        @endif
                                        @if('отклонена' == $correct->correct)
                                            <div class="alert alert-danger" role="alert">
                                                @endif
                                                @if('отправлена на доработку' == $correct->correct)
                                                    <div class="alert alert-warning" role="alert">
                                                        @endif
                                                        <form
                                                            action="{{ route('theme.practical.correct.delete', $correct['id']) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit" class="close">×</button>
                                                        </form>
                                                        <h3>Практическая {{$correct->correct}}</h3>
                                                        @if($correct['body'])
                                                            <p>{{$correct->body}}</p>
                                                        @endif
                                                    </div>
                                                    @endforeach
                                            </div>
                                            <div class="card-body">
                                                <form method="post" action="{{ route('practical.reply.add') }}"
                                                      enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label>2. Ответить</label>
                                                        <input type="text" name="body" class="form-control"
                                                               placeholder="Ответить"/>
                                                        <input type="hidden" name="practical_id"
                                                               value="{{ $practical->id }}"/>
                                                        <input type="hidden" name="comment_id"
                                                               value="{{ $comment->id }}"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Текстовый файл</label>
                                                        <input type="file" name="file" class="form-control-file">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Картинка</label>
                                                        <input type="file" name="img" class="form-control-file">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Отправить</button>
                                                </form>
                                            </div>
                                            <div class="card-body">
                                                <form method="post"
                                                      action="{{ route('theme.practical.correct.send', $practical['id']) }}">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label>3. Отправить правильное решение</label>
                                                        <input type="hidden" name="to_user_id"
                                                               value="{{ $comment->user->id }}"/>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Отправить</button>
                                                </form>
                                            </div>
{{--                                            <div class="card-body">--}}
{{--                                                <form method="post"--}}
{{--                                                      action="{{ route('theme.practical.status', $practical['id']) }}">--}}
{{--                                                    @csrf--}}
{{--                                                    <practical-status></practical-status>--}}
{{--                                                    <button type="submit" class="btn btn-primary">Отправить</button>--}}
{{--                                                </form>--}}
{{--                                            </div>--}}
                                            <div class="card-footer text-muted">
                                                <form action="{{ route('practical.comment.delete', $comment['id']) }}"
                                                      method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-muted"
                                                            style="border: none; background: none; height: 20px; font-size: 14px; line-height: 100%; cursor: pointer;">
                                                        Удалить
                                                    </button>
                                                </form>
                                            </div>
                                            <ul class="list-group list-group-flush">
                                                @foreach($comment->replies as $reply)
                                                    <h5 class="card-header">Ответы на сообщение:</h5>
                                                    <li class="list-group-item">
                                                        @if($reply['image'])
                                                            <img
                                                                style="object-fit: cover; width: 100%; height: 25rem; object-fit: cover;"
                                                                src="{{ $reply['image']}}">
                                                        @endif
                                                        @if($reply['file'])
                                                            <a class="card-link"
                                                               href="{{ $reply['file'] }}" download="">Документ</a>
                                                        @endif
                                                        <div class="card-body">
                                                            <div class="row"
                                                                 style="margin: 0; align-items: center; justify-content: space-between;">
                                                                <h5 class="card-title">От {{ $reply->user->name }}</h5>
                                                                <div class="card-text"><small
                                                                        class="text-muted">{{ $reply->DateAsCorbon->diffForHumans() }}</small>
                                                                </div>
                                                            </div>
                                                            <p class="card-text">{{ $reply->body }}</p>
                                                            @if($reply['file'])
                                                                <a class="card-link"
                                                                   href="{{$reply['file'] }}" download="">Документ</a>
                                                            @endif
                                                        </div>
                                                        <div class="card-footer text-muted">
                                                            <form
                                                                action="{{ route('reply.comment.delete', $reply['id']) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button type="submit"
                                                                        class="text-muted comment-display-btn"
                                                                        style="border: none; background: none; height: 20px; font-size: 14px; line-height: 100%; cursor: pointer;">
                                                                    Удалить
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                    </div>
                        </div>
                        @endforeach
                    </div>
    </section>
    <!-- /.content -->
@endsection
