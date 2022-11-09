@extends('layouts.main_layout')

@section('content')
    @include('partials.header')
    <section id="person">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-4">
                    <div class="person__img person_image_margin">
                        <img
                            src="{{ Auth::user()->img_url ? Auth::user()->img_url : ('images/default-avatar.jpg') }}"
                            alt="person" class="img-responsive mx-auto d-block">
                    </div>
                </div>
                <ul class="only_desktop person__list col-lg-7 col-8">
                    <div class="row">
                        <div class="col-lg-12">
                            <li class="person__item">
                                <p>
                                    ФИО
                                </p>
                                <div>
                                    {{ Auth::user()->name }}
                                </div>
                            </li>
                            <li class="person__item">
                                <p>
                                    дата рождения
                                </p>
                                <div>
                                    {{ Auth::user()->birth ? date_format(date_create(Auth::user()->birth), 'd.m.Y') : 'не указана' }}
                                </div>
                            </li>
                            <li class="person__item">
                                <p>
                                    пол
                                </p>
                                <div>
                                    {{ Auth::user()->sex }}
                                </div>
                            </li>
                            <li class="person__item">
                                <p>
                                    город
                                </p>
                                <div>
                                    {{ Auth::user()->city ? Auth::user()->city : 'не указан' }}
                                </div>
                            </li>
                        </div>
                        <div class="col-lg-12">
                            <li class="person__item">
                                <p>
                                    учебное заведение
                                </p>
                                <div class="font">
                                    {{ Auth::user()->school ? Auth::user()->school->title : 'не указано'}}
                                    {{ Auth::user()->grade ? Auth::user()->grade . " класс" : ""}}
                                </div>
                            </li>
                        </div>
                    </div>
                </ul>
                <ul class="only_mobile person__list col-lg-7 col-8">
                    <div class="row">
                        <div class="col-lg-12">
                            <li class="person__item">
                                <p>
                                    ФИО
                                </p>
                                <div>
                                    {{ Auth::user()->name }}
                                </div>
                            </li>
                            <li class="person__item">
                                <p>
                                    дата рождения
                                </p>
                                <div>
                                    {{ Auth::user()->birth ? date_format(date_create(Auth::user()->birth), 'd.m.Y') : 'не указана' }}
                                </div>
                            </li>
                        </div>
                        <div id="collapseProfile" class="collapse show">
                            <div class="col-lg-12">
                                <li class="person__item">
                                    <p>
                                        пол
                                    </p>
                                    <div>
                                        {{ Auth::user()->sex }}
                                    </div>
                                </li>
                                <li class="person__item">
                                    <p>
                                        город
                                    </p>
                                    <div>
                                        {{ Auth::user()->city ? Auth::user()->city : 'не указан' }}
                                    </div>
                                </li>
                                <li class="person__item">
                                    <p>
                                        учебное заведение
                                    </p>
                                    <div class="font">
                                        {{ Auth::user()->school ? Auth::user()->school->title : 'не указано'}}
                                        {{ Auth::user()->grade ? Auth::user()->grade . " класс" : ""}}
                                    </div>
                                </li>
                            </div>
                        </div>
                    </div>
                </ul>
                <div class="person__btn-elem col-lg-3">
                    <button class="person__btn">
                        <a href="{{route('settings')}}">Настройки</a>
                    </button>
                    @role('admin|teacher')
                    <button style="margin-top:25px; height: auto; min-height: 40px" class="person__btn">
                        <a href="{{route('other.courses')}}"> Все курсы школы</a>
                    </button>
                    @endrole
                    <button
                        type="button" data-toggle="collapse" data-target="#collapseProfile" aria-expanded="true"
                        aria-controls="collapseProfile"
                        id="button_hide_profile_info" class="person__btn btn-hide">
                        <div style="color:white">
                                <span>
                                    <i class="fa fa-angle-up"></i>
                                </span>
                            Скрыть описание профиля
                        </div>
                        <div class="profile_visibity" style="color:white">
                                <span>
                                    <i class="fa fa-angle-down"></i>
                                </span>
                            Показать описание профиля
                        </div>
                    </button>
                    <!--<button id="button_show_profile_info" class="person__btn btn-hide profile_visibity">
                        <div style="color:white">
                                <span>
                                    <i class="fa fa-angle-down"></i>
                                </span>
                            Показать описание профиля</div>
                    </button>-->
                </div>

            </div>
        </div>
    </section>
    <section id="courses">
        <div class="container" id="app">
            @role('parent')
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                       aria-controls="home" aria-selected="true">Ученик 1</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                       aria-controls="profile" aria-selected="false">Ученик 2</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                       aria-controls="contact" aria-selected="false">Ученик 3</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">Предметы
                    ученика 1
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">Предметы ученика
                    2
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">Предметы ученика
                    3
                </div>
            </div>
            @endrole
            @role('admin|teacher|student|individual')
            <h2>
                Мои предметы
            </h2>
            @foreach ($courses as $key => $course)
                <div class="progress row" style="margin-left: 0">
                    <line-progress :percent="{{ $course->completePercent(Auth::user()->id) }}"></line-progress>
                </div>
                <div class="courses__block">
                    <button
                        type="button" data-toggle="collapse" data-target=".multi-collapse-{{$key}}"
                        aria-expanded="false"
                        aria-controls="multiCollapseImg{{$key}} multiCollapseText{{$key}} multiCollapseInfo{{$key}}"
                        id="button_hide_course_info_{{$key}}" style="background-color: white"
                        class="person__btn btn-hide">
                        <div class="profile_visibity">
                        <span>
                            <i class="fa fa-angle-up"></i>
                        </span>
                            Скрыть
                        </div>
                        <div>
                    <span>
                        <i class="fa fa-angle-down"></i>
                    </span>
                            Раскрыть
                        </div>
                    </button>
                    <div class="courses__img col-md-4 col-lg-3 only_desktop">
                        <img onclick="location.href='{{ route('course.show.user', $course['id']) }}'"
                             style="object-fit: cover; cursor:pointer"
                             src="{{ $course->img_url ? $course->img_url : ('/images/math.jpg')  }}" alt="courses">
                    </div>
                    <div class="collapse multi-collapse-{{$key}} only_mobile" id="multiCollapseImg{{$key}}">
                        <div class="courses__img col-md-4 col-lg-3">
                            <img onclick="location.href='{{ route('course.show.user', $course['id']) }}'"
                                 style="object-fit: cover; cursor:pointer"
                                 src="{{ $course->img_url ? $course->img_url : ('/images/math.jpg')  }}" alt="courses">
                        </div>
                    </div>
                    <div class="courses__elem col-md-8 col-lg-9">
                        <div class="courses__elem-up">
                            <div class="courses__caption">
                                <a class="courses__title" href="{{ route('course.show.user', $course['id']) }}">
                                    {{ $course->title }}
                                </a>
                                <div class="courses__percent">
                                    <percent-counter
                                        :percent="{{$course->completePercent(Auth::user()->id)}}"></percent-counter>
                                    <p>
                                        изучено
                                    </p>
                                </div>
                            </div>
                            <div class="courses__txt col-md-10 only_desktop">
                                {{ $course->description }}
                            </div>
                            <div class="collapse multi-collapse-{{$key}} only_mobile" id="multiCollapseText{{$key}}">
                                <div class="courses__txt col-md-10">
                                    {{ $course->description }}
                                </div>
                            </div>
                            <div class="collapse multi-collapse-{{$key}} only_mobile" id="multiCollapseInfo{{$key}}">
                                <div class="courses__elem-info row">
                                    <svg style="
                                width: 26px;
                                height: 26px;
                                margin-right: 10px;
                                fill: #fabe4b;" height="512pt" viewBox="0 0 512 512" width="512pt"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="m369.164062 174.769531c7.8125 7.8125 7.8125 20.476563 0 28.285157l-134.171874 134.175781c-7.8125 7.808593-20.472657 7.808593-28.285157 0l-63.871093-63.875c-7.8125-7.808594-7.8125-20.472657 0-28.28125 7.808593-7.8125 20.472656-7.8125 28.28125 0l49.730468 49.730469 120.03125-120.035157c7.8125-7.808593 20.476563-7.808593 28.285156 0zm142.835938 81.230469c0 141.503906-114.515625 256-256 256-141.503906 0-256-114.515625-256-256 0-141.503906 114.515625-256 256-256 141.503906 0 256 114.515625 256 256zm-40 0c0-119.394531-96.621094-216-216-216-119.394531 0-216 96.621094-216 216 0 119.394531 96.621094 216 216 216 119.394531 0 216-96.621094 216-216zm0 0"/>
                                    </svg>
                                    <p class="exp-prg">
                                        {{ $course->countThemes() }} тем
                                        <br>({{ $course->completeCount(Auth::user()->id) }} выполнено)
                                    </p>
                                    @if ($course->hours)
                                        <svg style="
                                width: 26px;
                                height: 26px;
                                margin-right: 10px;
                                fill: #fabe4b;" height="512pt" viewBox="0 0 512 512" width="512pt"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="m369.164062 174.769531c7.8125 7.8125 7.8125 20.476563 0 28.285157l-134.171874 134.175781c-7.8125 7.808593-20.472657 7.808593-28.285157 0l-63.871093-63.875c-7.8125-7.808594-7.8125-20.472657 0-28.28125 7.808593-7.8125 20.472656-7.8125 28.28125 0l49.730468 49.730469 120.03125-120.035157c7.8125-7.808593 20.476563-7.808593 28.285156 0zm142.835938 81.230469c0 141.503906-114.515625 256-256 256-141.503906 0-256-114.515625-256-256 0-141.503906 114.515625-256 256-256 141.503906 0 256 114.515625 256 256zm-40 0c0-119.394531-96.621094-216-216-216-119.394531 0-216 96.621094-216 216 0 119.394531 96.621094 216 216 216 119.394531 0 216-96.621094 216-216zm0 0"/>
                                        </svg>
                                        <p class="exp-prg">
                                            @if($course->hours % 10  == 1)
                                                {{ $course->hours }} час <br>обучения
                                            @elseif($course->hours % 10  == 2 || $course->hours % 10  == 3  || $course->hours % 10  == 4)
                                                {{ $course->hours }} часa <br>обучения
                                            @else
                                                {{ $course->hours }} часов <br>обучения
                                            @endif
                                        </p>
                                    @endif
                                    <div class="courses__expert expert row">
                                        <div class="expert__txt">
                                            <div>
                                                учитель
                                            </div>
                                            <p>
                                                {{ $course->user->name }}
                                            </p>
                                        </div>
                                        <img
                                            src="{{ $course->user->img_url ? $course->user->img_url : ('/images/default-avatar.jpg') }}"
                                            alt="courses"
                                            class="img-responsive mx-auto d-block">
                                    </div>
                                </div>
                            </div>
                            <div class="courses__elem-info row only_desktop">
                                <svg style="
                            width: 26px;
                            height: 26px;
                            margin-right: 10px;
                            fill: #fabe4b;" height="512pt" viewBox="0 0 512 512" width="512pt"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="m369.164062 174.769531c7.8125 7.8125 7.8125 20.476563 0 28.285157l-134.171874 134.175781c-7.8125 7.808593-20.472657 7.808593-28.285157 0l-63.871093-63.875c-7.8125-7.808594-7.8125-20.472657 0-28.28125 7.808593-7.8125 20.472656-7.8125 28.28125 0l49.730468 49.730469 120.03125-120.035157c7.8125-7.808593 20.476563-7.808593 28.285156 0zm142.835938 81.230469c0 141.503906-114.515625 256-256 256-141.503906 0-256-114.515625-256-256 0-141.503906 114.515625-256 256-256 141.503906 0 256 114.515625 256 256zm-40 0c0-119.394531-96.621094-216-216-216-119.394531 0-216 96.621094-216 216 0 119.394531 96.621094 216 216 216 119.394531 0 216-96.621094 216-216zm0 0"/>
                                </svg>
                                <p class="exp-prg">
                                    {{ $course->countThemes() }} тем <br>({{ $course->completeCount(Auth::user()->id) }}
                                    выполнено)
                                </p>
                                @if ($course->hours)
                                    <svg style="
                            width: 26px;
                            height: 26px;
                            margin-right: 10px;
                            fill: #fabe4b;" height="512pt" viewBox="0 0 512 512" width="512pt"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="m369.164062 174.769531c7.8125 7.8125 7.8125 20.476563 0 28.285157l-134.171874 134.175781c-7.8125 7.808593-20.472657 7.808593-28.285157 0l-63.871093-63.875c-7.8125-7.808594-7.8125-20.472657 0-28.28125 7.808593-7.8125 20.472656-7.8125 28.28125 0l49.730468 49.730469 120.03125-120.035157c7.8125-7.808593 20.476563-7.808593 28.285156 0zm142.835938 81.230469c0 141.503906-114.515625 256-256 256-141.503906 0-256-114.515625-256-256 0-141.503906 114.515625-256 256-256 141.503906 0 256 114.515625 256 256zm-40 0c0-119.394531-96.621094-216-216-216-119.394531 0-216 96.621094-216 216 0 119.394531 96.621094 216 216 216 119.394531 0 216-96.621094 216-216zm0 0"/>
                                    </svg>
                                    <p class="exp-prg">
                                        @if($course->hours % 10  == 1)
                                            {{ $course->hours }} час <br>обучения
                                        @elseif($course->hours % 10  == 2 || $course->hours % 10  == 3  || $course->hours % 10  == 4)
                                            {{ $course->hours }} часa <br>обучения
                                        @else
                                            {{ $course->hours }} часов <br>обучения
                                        @endif
                                    </p>
                                @endif
                                <div class="courses__expert expert row">
                                    <div class="expert__txt">
                                        <div>
                                            учитель
                                        </div>
                                        <p>
                                            {{ $course->user->name }}
                                        </p>
                                    </div>
                                    <img
                                        src="{{ $course->user->img_url ? $course->user->img_url : ('/images/default-avatar.jpg') }}"
                                        alt="courses"
                                        class="img-responsive mx-auto d-block">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="w100 d-flex justify-content-center mt-2">
            {{ $courses->links() }}
        </div>
        @endrole

    </section>
    @include('partials.footer')
@endsection
