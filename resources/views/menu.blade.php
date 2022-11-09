@extends('layouts.main_layout')

@section('content')
    @include('partials.header')
    <section id="structure" class="account">
        <div id="app" class="container">
            @include('partials.menu_top', ['chapter' => $theme->chapter])
            <h2>
                <b>модуль: </b>{{ $theme->chapter->title }}
            </h2>
            <div id="pass" class="pass">
                <div style="margin-left:0; margin-right:0" class="row">
                    <div class="col-12 pass-menu">
                        <p class="menu-title">
                            Тема: {{ $theme->title }}
                        </p>
                        <div class="row main-menu">
                            @if ($is_theory)
                                <div class="col-12 col-lg-4">
                                    <a href="{{ route('theme.materials', [$theme['id'], 1]) }}">Теория</a>
                                </div>
                            @endif
                            @if ($is_materials)
                                <div class="col-12 col-lg-4">
                                    <a href="{{ route('theme.materials', [$theme['id'], 2]) }}">Дополнительные
                                        материалы</a>
                                </div>
                            @endif
                            @if ($is_practice)
                                <div class="col-12 col-lg-4">
                                    <a href="{{ route('theme.materials', [$theme['id'], 3]) }}">Практика</a>
                                </div>
                            @endif
                            @if ($is_home)
                                <div class="col-12 col-lg-4">
                                    <a href="{{ route('theme.materials', [$theme['id'], 4]) }}">Домашнее задание</a>
                                </div>
                            @endif
                            @if ($is_control)
                                <div class="col-12 col-lg-4">
                                    <a href="{{ route('theme.materials', [$theme['id'], 5]) }}">Контроль</a>
                                </div>
                            @endif
                            <div class="col-12 col-lg-4">
                                <a href="{{ route('all.theme.practicals', $theme['id']) }}">Практичекие работы</a>
                            </div>
                        </div>

                        <div class="comment-container row">
                            <div class="col-md-7">
                                <h4>Комментировать</h4>
                                @if (session('success'))
                                    <div class="alert alert-success" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        {{ session('success') }}
                                    </div>
                                @endif
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
                                <form class="comment-form mb-4" method="post" action="{{ route('comment.add') }}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group" style="position: relative;">
                                        <input type="text" name="body" class="form-control"/>
                                        <input type="hidden" name="theme_id" value="{{ $theme->id }}"/>
                                        <file-add></file-add>
                                    </div>
                                    <button type="submit"
                                            class="btn border-orange btn-warning background-orange_hover background-orange text-white">
                                        Отправить
                                    </button>
                                </form>
                                @foreach($theme->comments as $comment)
                                    <div class="comment-display">
                                        <div class="comment-display-row">
                                            <div class="comment-display__avatar-img-block">
                                                <img
                                                    src="{{ $comment->user->img_url ? $comment->user->img_url : ('/images/default-avatar.jpg') }}"
                                                    alt="courses"
                                                    class="object-fit">
                                            </div>
                                            <div class="comment-display-text">
                                                <div class="comment-display__avatar-row">
                                                    <strong class="comment-display-text_strong">
                                                        {{ $comment->user->name }}
                                                    </strong>
                                                    <p class="text-muted text-sm">
                                                        {{ $comment->DateAsCorbon->diffForHumans() }}
                                                    </p>
                                                </div>
                                                <p class="comment-display-prg">{!! $comment->body !!}</p>
                                                @if($comment['image'])
                                                    <div class="comment-display-img-block" style="margin: 10px 0">
                                                        <img class="object-fit" src="{{ $comment['image']}}">
                                                    </div>
                                                @endif
                                                @if($comment['file'])
                                                    <a class="file-link badge text-white background-orange background-orange_hover"
                                                       href="{{ $comment['file'] }}" download="">Документ</a>
                                                @endif
                                                <form action="{{ route('comment.delete', $comment['id']) }}" method="POST"
                                                      style="width: 100%; display: flex; justify-content: flex-end;">
                                                    @csrf
                                                    <button type="submit" class="text-muted comment-display-btn">
                                                        Удалить
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        @foreach($comment->replies as $reply)
                                            <div class="comment-display-row">
                                                <div class="comment-display__avatar-img-block">
                                                    <img
                                                        src="{{ $comment->user->img_url ? $comment->user->img_url : ('/images/default-avatar.jpg') }}"
                                                        alt="courses"
                                                        class="object-fit">
                                                </div>
                                                <div class="comment-display-text">
                                                    <div class="comment-display__avatar-row">
                                                        <strong class="comment-display-text_strong">
                                                            {{ $reply->user->name }}
                                                        </strong>
                                                        <p class="text-muted text-sm">
                                                            {{ $reply->DateAsCorbon->diffForHumans() }}
                                                        </p>
                                                    </div>
                                                    <p class="comment-display-prg">{{ $reply->body }}</p>
                                                    @if($reply['image'])
                                                        <div class="comment-display-img-block" style="margin: 10px 0">
                                                            <img class="object-fit" src="{{ $reply['image']}}">
                                                        </div>
                                                    @endif
                                                    @if($reply['file'])
                                                        <a class="file-link badge text-white background-orange background-orange_hover"
                                                           href="{{ $reply['file'] }}" download="">Документ</a>
                                                    @endif
                                                    <form action="{{ route('reply.comment.delete', $reply['id']) }}" method="POST"
                                                          style="width: 100%; display: flex; justify-content: flex-end;">
                                                        @csrf
                                                        <button type="submit" class="text-muted comment-display-btn">
                                                            Удалить
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                        <form method="post" action="{{ route('reply.add') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group comment-display-form-group">
                                                <input type="text" name="body"
                                                       class="form-control comment-display-form-control"/>
                                                <input type="hidden" name="theme_id" value="{{ $theme->id }}"/>
                                                <input type="hidden" name="comment_id" value="{{ $comment->id }}"/>
                                                <file-add></file-add>
                                            </div>
                                            <button type="submit"
                                                    class="btn border-orange btn-warning background-orange_hover background-orange text-white">
                                                Отправить
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('partials.footer')
@endsection
