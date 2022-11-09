@extends('layouts.main_layout')

@section('content')
    @include('partials.header')
    <section id="structure" class="account">
        <div id="app" class="container">
            @include('partials.section_top', ['chapter' => $theme->chapter])
            <h2>
                <b>модуль: </b>{{ $theme->chapter->title }}
            </h2>
            <div id="pass" class="pass">
                <div style="margin-left:0; margin-right:0" class="row">
                    <div class="col-lg-4 pass-menu">
                        <p class="menu-title">
                            Тема: {{ $theme->title }}
                        </p>
                        <nav class="menu">
                            @if ($theme->videosCount > 0)
                                <a href="{{ route('all.theme.video', [$theme['id']]) }}">Видео-урок по теме</a>
                            @endif
                            @if ($theme->presentationsCount > 0)
                                <a href="{{ route('all.theme.presentations', [$theme['id']]) }}">Презентация по теме</a>
                            @endif
                            <a href="{{ route('all.theme.materials', [$theme['id']]) }}">Дополнительные
                                материалы по теме</a>
                            @if ($theme->testsCount > 0)
                                <a href="{{ route('all.theme.test', [$theme['id']]) }}">Тесты по теме</a>
                            @endif
                            <a class="menu_active_tab" href="{{ route('all.theme.practicals', $theme['id']) }}">Практичекие
                                работы</a>
                        </nav>
                    </div>
                    <div class="offset-lg-1 col-lg-7 materials-block">
                        <div class="practicals-list">
                            <h3><strong>Задача: {{ $practical->title }}</strong></h3>
                            @foreach($practical->corrects as $correct)
                                @if(auth()->user()->id  == $correct->to_user_id)
                                    <div class="alert"
                                         @if('принята' == $correct->correct)class="alert-success" @endif
                                         @if('отклонена' == $correct->correct)class="alert-danger" @endif
                                         @if('отправлена на доработку' == $correct->correct)class="alert-warning" @endif
                                         role="alert">
                                        {{--                                    @if('принята' == $correct->correct)--}}
                                        {{--                                        <div class="alert alert-success" role="alert">--}}
                                        {{--                                            @endif--}}
                                        {{--                                            @if('отклонена' == $correct->correct)--}}
                                        {{--                                                <div class="alert alert-danger" role="alert">--}}
                                        {{--                                                    @endif--}}
                                        {{--                                                    @if('отправлена на доработку' == $correct->correct)--}}
                                        {{--                                                        <div class="alert alert-warning" role="alert">--}}
                                        {{--                                                            @endif--}}
                                        <button type="button" class="close" data-dismiss="alert"
                                                aria-hidden="true">×
                                        </button>
                                        <h3>Практическая {{$correct->correct}}</h3>
                                        @if($correct['body'])
                                            <p>{{$correct->body}}</p>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                            <div class="practicals-contaner">
                                @if(auth()->user()->id  == $practical->to_user_id)
                                    <div class="practicals-block practicals-correct-block">
                                        <strong class="practicals-subtitle" style="">
                                            Правильное решение
                                        </strong>
                                        <p class="practicals-text">
                                            {!! $practical->correct !!}
                                        </p>
                                        @if($practical['correct_file'])
                                        </br>
                                        <a class="badge text-white background-orange_hover background-orange"
                                           href="{{ $practical['correct_file'] }}" download="">Файл
                                            правильного решения</a>
                                        @endif
                                    </div>
                                @endif
                                <div class="practicals-block">
                                    <strong class="practicals-subtitle" style="">
                                        Цель домашнего задания
                                    </strong>
                                    <p class="practicals-text">
                                        {{ $practical->purpose }}
                                    </p>
                                </div>
                                <div class="practicals-block">
                                    <strong class="practicals-subtitle" style="">
                                        Что нужно сделать
                                    </strong>
                                    <p class="practicals-text">
                                        {!! $practical->task !!}
                                    </p>
                                    <div class="row" style="margin: 0.5rem 0 0;">
                                        @if($practical['link'])
                                        </br>
                                        <a class="badge text-white background-orange background-orange_hover"
                                           style="margin-right: 1.5rem;"
                                           href="{{ $practical->link }}">Ссылка для задачи</a>
                                        @endif
                                        @if($practical['file'])
                                        </br>
                                        <a class="badge text-white background-orange_hover background-orange"
                                           href="{{ $practical['file'] }}" download="">Материалы
                                            для задачи</a>
                                        @endif
                                        @if($practical['image'])
                                        </br>
                                        <div class="comment-display-img-block"
                                             style="margin: 10px 0">
                                            <img class="object-fit"
                                                 src="{{ $practical['image']}}">
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="practicals-block">
                                    <strong class="practicals-subtitle" style="">
                                        Рекомендации по выполнению
                                    </strong>
                                    <p class="practicals-text">
                                        {{ $practical->recommendations }}
                                    </p>
                                </div>
                                <div class="practicals-block">
                                    <strong class="practicals-subtitle" style="">
                                        Критерии оценки
                                    </strong>
                                    <p class="practicals-text">
                                        {{ $practical->criteria }}
                                    </p>
                                </div>
                                <div class="practicals-block">
                                    <strong class="practicals-subtitle" style="">
                                        Как отправить задание на проверку
                                    </strong>
                                    <p class="practicals-text">
                                        {{ $practical->howtosend }}
                                    </p>
                                </div>
                            </div>
                            <form method="post"
                                  action="{{ route('theme.practical.feedback') }}">
                                @csrf
                                <input type="hidden" name="practical_id"
                                       value="{{ $practical->id }}"/>
                                <practical-feedback></practical-feedback>
                            </form>
                        </div>
                        <div class="comment-container">
                            <h4>Отправить решение</h4>
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">×
                                    </button>
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">×
                                    </button>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form class="comment-form mb-4" method="post"
                                  action="{{ route('practical.comment.add') }}"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="form-group" style="position: relative;">
                                                            <textarea id="summernote" name="body"
                                                                      class="form-control"></textarea>
                                    <input type="hidden" name="practical_id"
                                           value="{{ $practical->id }}"/>
                                    @if(auth()->user()->id  == $practical->user_id)
                                        <input type="hidden" name="teacher_id"
                                               value="{{$practical->user_id}}"/>
                                    @endif
                                    <file-add></file-add>
                                </div>

                                <button type="submit"
                                        class="btn border-orange btn-warning background-orange_hover background-orange text-white">
                                    Отправить
                                </button>
                            </form>
                            @if('0' == $practical->status)
                               <div class="comment-display-block">
                                   @foreach($comments as $comment)
                                       <div class="comment-display comment-display_border">
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
                                                       <div class="comment-display-img-block"
                                                            style="margin: 10px 0">
                                                           <img class="object-fit"
                                                                src="{{ $comment['image']}}">
                                                       </div>
                                                   @endif
                                                   @if($comment['file'])
                                                       <a class="file-link badge text-white background-orange background-orange_hover"
                                                          href="{{ $comment['file'] }}" download="">Документ</a>
                                                   @endif
                                                   <form
                                                       action="{{ route('practical.comment.delete', $comment['id']) }}"
                                                       method="POST"
                                                       style="width: 100%; display: flex; justify-content: flex-end;">
                                                       @csrf
                                                       <button type="submit"
                                                               class="text-muted comment-display-btn">
                                                           Удалить
                                                       </button>
                                                   </form>
                                               </div>
                                           </div>
                                           @foreach($comment->replies as $reply)
                                               <div class="comment-reply">
                                                   <div class="comment-display-row">
                                                       <div class="comment-display__avatar-img-block">
                                                           <img
                                                               src="{{ $comment->user->img_url ? $comment->user->img_url : ('/images/default-avatar.jpg') }}"
                                                               alt="courses"
                                                               class="object-fit">
                                                       </div>
                                                       <div class="comment-display-text">
                                                           <div class="comment-display__avatar-row">
                                                               <strong
                                                                   class="comment-display-text_strong">
                                                                   {{ $reply->user->name }}
                                                               </strong>
                                                               <p class="text-muted text-sm">
                                                                   {{ $reply->DateAsCorbon->diffForHumans() }}
                                                               </p>
                                                           </div>
                                                           <p class="comment-display-prg">{{ $reply->body }}</p>
                                                           @if($reply['image'])
                                                               <div class="comment-display-img-block"
                                                                    style="margin: 10px 0">
                                                                   <img class="object-fit"
                                                                        src="{{ $reply['image']}}">
                                                               </div>
                                                           @endif
                                                           @if($reply['file'])
                                                               <a class="file-link badge text-white background-orange background-orange_hover"
                                                                  href="{{ $reply['file'] }}"
                                                                  download="">Документ</a>
                                                           @endif
                                                           <form
                                                               action="{{ route('reply.comment.delete', $reply['id']) }}"
                                                               method="POST"
                                                               style="width: 100%; display: flex; justify-content: flex-end;">
                                                               @csrf
                                                               <button type="submit"
                                                                       class="text-muted comment-display-btn">
                                                                   Удалить
                                                               </button>
                                                           </form>
                                                       </div>
                                                   </div>
                                               </div>
                                           @endforeach
                                           <form method="post"
                                                 action="{{ route('practical.reply.add') }}"
                                                 enctype="multipart/form-data">
                                               @csrf
                                               <div class="form-group comment-display-form-group">
                                                   <input type="text" name="body"
                                                          class="form-control comment-display-form-control"/>
                                                   <input type="hidden" name="practical_id"
                                                          value="{{ $practical->id }}"/>
                                                   <input type="hidden" name="comment_id"
                                                          value="{{ $comment->id }}"/>
                                                   @if(auth()->user()->id  == $practical->user_id)
                                                       <input type="hidden" name="teacher_id"
                                                              value="{{$practical->user_id}}"/>
                                                   @endif
                                                   <file-add></file-add>
                                               </div>
                                               <div class="form-group">
                                                   <button type="submit"
                                                           class="btn text-white border-orange background-orange background-orange_hover btn-warning">
                                                       Ответить
                                                   </button>
                                                   <div id="input_file"></div>
                                                   <div id="input_image"></div>
                                               </div>
                                           </form>
                                       </div>
                                   @endforeach
                               </div>
                            @else
                                <div class="comment-display-block">
                                    @foreach($practical->comments as $comment)
                                        <div class="comment-display comment-display_border">
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
                                                        <div class="comment-display-img-block"
                                                             style="margin: 10px 0">
                                                            <img class="object-fit"
                                                                 src="{{ $comment['image']}}">
                                                        </div>
                                                    @endif
                                                    @if($comment['file'])
                                                        <a class="file-link badge text-white background-orange background-orange_hover"
                                                           href="{{ $comment['file'] }}" download="">Документ</a>
                                                    @endif
                                                    <form
                                                        action="{{ route('practical.comment.delete', $comment['id']) }}"
                                                        method="POST"
                                                        style="width: 100%; display: flex; justify-content: flex-end;">
                                                        @csrf
                                                        <button type="submit"
                                                                class="text-muted comment-display-btn">
                                                            Удалить
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            @foreach($comment->replies as $reply)
                                                <div class="comment-reply">
                                                    <div class="comment-display-row">
                                                        <div class="comment-display__avatar-img-block">
                                                            <img
                                                                src="{{ $comment->user->img_url ? $comment->user->img_url : ('/images/default-avatar.jpg') }}"
                                                                alt="courses"
                                                                class="object-fit">
                                                        </div>
                                                        <div class="comment-display-text">
                                                            <div class="comment-display__avatar-row">
                                                                <strong
                                                                    class="comment-display-text_strong">
                                                                    {{ $reply->user->name }}
                                                                </strong>
                                                                <p class="text-muted text-sm">
                                                                    {{ $reply->DateAsCorbon->diffForHumans() }}
                                                                </p>
                                                            </div>
                                                            <p class="comment-display-prg">{{ $reply->body }}</p>
                                                            @if($reply['image'])
                                                                <div class="comment-display-img-block"
                                                                     style="margin: 10px 0">
                                                                    <img class="object-fit"
                                                                         src="{{ $reply['image']}}">
                                                                </div>
                                                            @endif
                                                            @if($reply['file'])
                                                                <a class="file-link badge text-white background-orange background-orange_hover"
                                                                   href="{{ $reply['file'] }}"
                                                                   download="">Документ</a>
                                                            @endif
                                                            <form
                                                                action="{{ route('reply.comment.delete', $reply['id']) }}"
                                                                method="POST"
                                                                style="width: 100%; display: flex; justify-content: flex-end;">
                                                                @csrf
                                                                <button type="submit"
                                                                        class="text-muted comment-display-btn">
                                                                    Удалить
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <form method="post"
                                                  action="{{ route('practical.reply.add') }}"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group comment-display-form-group">
                                                    <input type="text" name="body"
                                                           class="form-control comment-display-form-control"/>
                                                    <input type="hidden" name="practical_id"
                                                           value="{{ $practical->id }}"/>
                                                    <input type="hidden" name="comment_id"
                                                           value="{{ $comment->id }}"/>
                                                    @if(auth()->user()->id  == $practical->user_id)
                                                        <input type="hidden" name="teacher_id"
                                                               value="{{$practical->user_id}}"/>
                                                    @endif
                                                    <file-add></file-add>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit"
                                                            class="btn text-white border-orange background-orange background-orange_hover btn-warning">
                                                        Ответить
                                                    </button>
                                                    <div id="input_file"></div>
                                                    <div id="input_image"></div>
                                                </div>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('partials.footer')
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('plugin/summernote/summernote-bs4.min.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('plugin/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('plugin/summernote/lang/summernote-ru-RU.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#summernote').summernote({
                placeholder: 'Введите сообщение',
                tabsize: 2,
                height: 200,
                lang: 'ru-RU',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ol', 'ul', 'paragraph', 'height']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>
@endpush

