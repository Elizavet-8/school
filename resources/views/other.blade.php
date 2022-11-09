@extends('layouts.main_layout')

@section('content')
    @include('partials.header')
    <section id="structure" class="account">
        <div class="container">
            <div style="margin-left:0; margin-right:0" class="row account-block">
                <button onclick="location.href='{{ url('/home') }}'" class="btn-active account__btn">
                    <svg display="none">
                        <symbol viewBox="0 0 512.011 512.011" id="arrow">
                            <g>
                                <path d="M505.755,123.592c-8.341-8.341-21.824-8.341-30.165,0L256.005,343.176L36.421,123.592c-8.341-8.341-21.824-8.341-30.165,0
                         s-8.341,21.824,0,30.165l234.667,234.667c4.16,4.16,9.621,6.251,15.083,6.251c5.462,0,10.923-2.091,15.083-6.251l234.667-234.667
                         C514.096,145.416,514.096,131.933,505.755,123.592z"/>
                            </g>
                        </symbol>
                    </svg>
                    <svg class="arrow">
                        <use xlink:href="#arrow"></use>
                    </svg>
                    <p>Вернуться в профиль</p>
                </button>
            </div>
        </div>
    </section>
    <section id="courses">
        <style>
            .search-grade__btn {
                margin: 0 5px;
                border: none;
                background: none;
                color: #49505A;
                font-size: 16px;
                line-height: 22px;
                border-bottom: 2px solid #495057;
                border-radius: 0;
                padding: 0;
                font-weight: 600;
            }

            .search-grade__btns {
                display: grid;
                grid-template-columns: repeat(6, 1fr);
                grid-auto-rows: 35px;
                width: 50%;
            }

            .search-grade {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 40px;
            }

            @media (max-width: 992px) {
                .search-grade__btns {
                    grid-template-columns: repeat(4, 1fr);
                }
            }

            @media (max-width: 778px) {
                .search-grade {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .search-grade__btns {
                    display: flex;
                    flex-wrap: wrap;
                    width: 100%;
                    margin: 0 -10px;
                }

                .search-grade__btn {
                    margin: 10px;
                }
            }
        </style>
        <div class="container">
            <div class="search-grade">
                <h2 style="margin-bottom: 0">
                    Доступные курсы школы
                </h2>
                <div class="search-grade__btns">
                    <form action="{{ route('search.grade') }}" method="get">
                        <input type="hidden" name="search_grade" value="1">
                        <button type="submit"
                                class="search-grade__btn">
                            1 класс
                        </button>
                    </form>
                    <form action="{{ route('search.grade') }}" method="get">
                        <input type="hidden" name="search_grade" value="2">
                        <button type="submit"
                                class="search-grade__btn">
                            2 класс
                        </button>
                    </form>
                    <form action="{{ route('search.grade') }}" method="get">
                        <input type="hidden" name="search_grade" value="3">
                        <button type="submit"
                                class="search-grade__btn">
                            3 класс
                        </button>
                    </form>
                    <form action="{{ route('search.grade') }}" method="get">
                        <input type="hidden" name="search_grade" value="4">
                        <button type="submit"
                                class="search-grade__btn">
                            4 класс
                        </button>
                    </form>
                    <form action="{{ route('search.grade') }}" method="get">
                        <input type="hidden" name="search_grade" value="5">
                        <button type="submit"
                                class="search-grade__btn">
                            5 класс
                        </button>
                    </form>
                    <form action="{{ route('search.grade') }}" method="get">
                        <input type="hidden" name="search_grade" value="6">
                        <button type="submit"
                                class="search-grade__btn">
                            6 класс
                        </button>
                    </form>
                    <form action="{{ route('search.grade') }}" method="get">
                        <input type="hidden" name="search_grade" value="7">
                        <button type="submit"
                                class="search-grade__btn">
                            7 класс
                        </button>
                    </form>
                    <form action="{{ route('search.grade') }}" method="get">
                        <input type="hidden" name="search_grade" value="8">
                        <button type="submit"
                                class="search-grade__btn">
                            8 класс
                        </button>
                    </form>
                    <form action="{{ route('search.grade') }}" method="get">
                        <input type="hidden" name="search_grade" value="9">
                        <button type="submit"
                                class="search-grade__btn">
                            9 класс
                        </button>
                    </form>
                    <form action="{{ route('search.grade') }}" method="get">
                        <input type="hidden" name="search_grade" value="10">
                        <button type="submit"
                                class="search-grade__btn">
                            10 класс
                        </button>
                    </form>
                    <form action="{{ route('search.grade') }}" method="get">
                        <input type="hidden" name="search_grade" value="11">
                        <button type="submit"
                                class="search-grade__btn">
                            11 класс
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @if (count($courses))
            <div class="container" id="app">
                {{--        @foreach ($courses as $key => $course)--}}
                {{--            <div class="progress row" style="margin-left: 0">--}}
                {{--                <line-progress :percent="{{ $course->completePercent(Auth::user()->id) }}"></line-progress>--}}
                {{--            </div>--}}
                {{--        <div class="courses__block">--}}
                {{--            <button--}}
                {{--            type="button" data-toggle="collapse" data-target=".multi-collapse-{{$key}}" aria-expanded="false" aria-controls="multiCollapseImg{{$key}} multiCollapseText{{$key}} multiCollapseInfo{{$key}}"--}}
                {{--            id="button_hide_course_info_{{$key}}" style="background-color: white" class="person__btn btn-hide">--}}
                {{--                <div class="profile_visibity">--}}
                {{--                    <span>--}}
                {{--                        <i class="fa fa-angle-up"></i>--}}
                {{--                    </span>--}}
                {{--                        Скрыть</div>--}}
                {{--                <div>--}}
                {{--                <span>--}}
                {{--                    <i class="fa fa-angle-down"></i>--}}
                {{--                </span>--}}
                {{--                    Раскрыть</div>--}}
                {{--            </button>--}}
                {{--            <div class="courses__img col-md-4 col-lg-3 only_desktop">--}}
                {{--                <img onclick="location.href='{{ route('course.show.user', $course['id']) }}'" style="object-fit: cover; cursor:pointer" src="{{ $course->img_url ? $course->img_url : ('/images/math.jpg')  }}" alt="courses">--}}
                {{--            </div>--}}
                {{--            <div class="collapse multi-collapse-{{$key}} only_mobile" id="multiCollapseImg{{$key}}">--}}
                {{--                <div class="courses__img col-md-4 col-lg-3">--}}
                {{--                    <img onclick="location.href='{{ route('course.show.user', $course['id']) }}'" style="object-fit: cover; cursor:pointer" src="{{ $course->img_url ? $course->img_url : ('/images/math.jpg')  }}" alt="courses">--}}
                {{--                </div>--}}
                {{--            </div>--}}
                {{--            <div class="courses__elem col-md-8 col-lg-9">--}}
                {{--                <div class="courses__elem-up">--}}
                {{--                    <div class="courses__caption">--}}
                {{--                        <a class="courses__title" href="{{ route('course.show.user', $course['id']) }}">--}}
                {{--                            {{ $course->title }}--}}
                {{--                        </a>--}}
                {{--                        <div class="courses__percent">--}}
                {{--                            <percent-counter :percent="{{$course->completePercent(Auth::user()->id)}}"></percent-counter>--}}
                {{--                            <p>--}}
                {{--                                изучено--}}
                {{--                            </p>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                    <div class="courses__txt col-md-10 only_desktop">--}}
                {{--                        {{ $course->description }}--}}
                {{--                    </div>--}}
                {{--                    <div class="collapse multi-collapse-{{$key}} only_mobile" id="multiCollapseText{{$key}}">--}}
                {{--                        <div class="courses__txt col-md-10">--}}
                {{--                            {{ $course->description }}--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                    <div class="collapse multi-collapse-{{$key}} only_mobile" id="multiCollapseInfo{{$key}}">--}}
                {{--                        <div class="courses__elem-info row">--}}
                {{--                            <svg style="--}}
                {{--                            width: 26px;--}}
                {{--                            height: 26px;--}}
                {{--                            margin-right: 10px;--}}
                {{--                            fill: #fabe4b;" height="512pt" viewBox="0 0 512 512" width="512pt" xmlns="http://www.w3.org/2000/svg"><path d="m369.164062 174.769531c7.8125 7.8125 7.8125 20.476563 0 28.285157l-134.171874 134.175781c-7.8125 7.808593-20.472657 7.808593-28.285157 0l-63.871093-63.875c-7.8125-7.808594-7.8125-20.472657 0-28.28125 7.808593-7.8125 20.472656-7.8125 28.28125 0l49.730468 49.730469 120.03125-120.035157c7.8125-7.808593 20.476563-7.808593 28.285156 0zm142.835938 81.230469c0 141.503906-114.515625 256-256 256-141.503906 0-256-114.515625-256-256 0-141.503906 114.515625-256 256-256 141.503906 0 256 114.515625 256 256zm-40 0c0-119.394531-96.621094-216-216-216-119.394531 0-216 96.621094-216 216 0 119.394531 96.621094 216 216 216 119.394531 0 216-96.621094 216-216zm0 0"/></svg>--}}
                {{--                            <p class="exp-prg">--}}
                {{--                                {{ $course->countThemes() }} тем <br>({{ $course->completeCount(Auth::user()->id) }} выполнено)--}}
                {{--                            </p>--}}
                {{--                            @if ($course->hours)--}}
                {{--                            <svg style="--}}
                {{--                            width: 26px;--}}
                {{--                            height: 26px;--}}
                {{--                            margin-right: 10px;--}}
                {{--                            fill: #fabe4b;" height="512pt" viewBox="0 0 512 512" width="512pt" xmlns="http://www.w3.org/2000/svg"><path d="m369.164062 174.769531c7.8125 7.8125 7.8125 20.476563 0 28.285157l-134.171874 134.175781c-7.8125 7.808593-20.472657 7.808593-28.285157 0l-63.871093-63.875c-7.8125-7.808594-7.8125-20.472657 0-28.28125 7.808593-7.8125 20.472656-7.8125 28.28125 0l49.730468 49.730469 120.03125-120.035157c7.8125-7.808593 20.476563-7.808593 28.285156 0zm142.835938 81.230469c0 141.503906-114.515625 256-256 256-141.503906 0-256-114.515625-256-256 0-141.503906 114.515625-256 256-256 141.503906 0 256 114.515625 256 256zm-40 0c0-119.394531-96.621094-216-216-216-119.394531 0-216 96.621094-216 216 0 119.394531 96.621094 216 216 216 119.394531 0 216-96.621094 216-216zm0 0"/></svg>--}}
                {{--                            <p class="exp-prg">--}}
                {{--                                {{ $course->hours }} часов <br>обучения--}}
                {{--                            </p>--}}
                {{--                            @endif--}}
                {{--                            <div class="courses__expert expert row">--}}
                {{--                                <div class="expert__txt">--}}
                {{--                                    <div>--}}
                {{--                                        учитель--}}
                {{--                                    </div>--}}
                {{--                                    <p>--}}
                {{--                                        {{ $course->user->name }}--}}
                {{--                                    </p>--}}
                {{--                                </div>--}}
                {{--                                <img src="{{ $course->user->img_url ? $course->user->img_url : ('/images/default-avatar.jpg') }}" alt="courses"--}}
                {{--                                     class="img-responsive mx-auto d-block">--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                    <div class="courses__elem-info row only_desktop">--}}
                {{--                        <svg style="--}}
                {{--                        width: 26px;--}}
                {{--                        height: 26px;--}}
                {{--                        margin-right: 10px;--}}
                {{--                        fill: #fabe4b;" height="512pt" viewBox="0 0 512 512" width="512pt" xmlns="http://www.w3.org/2000/svg"><path d="m369.164062 174.769531c7.8125 7.8125 7.8125 20.476563 0 28.285157l-134.171874 134.175781c-7.8125 7.808593-20.472657 7.808593-28.285157 0l-63.871093-63.875c-7.8125-7.808594-7.8125-20.472657 0-28.28125 7.808593-7.8125 20.472656-7.8125 28.28125 0l49.730468 49.730469 120.03125-120.035157c7.8125-7.808593 20.476563-7.808593 28.285156 0zm142.835938 81.230469c0 141.503906-114.515625 256-256 256-141.503906 0-256-114.515625-256-256 0-141.503906 114.515625-256 256-256 141.503906 0 256 114.515625 256 256zm-40 0c0-119.394531-96.621094-216-216-216-119.394531 0-216 96.621094-216 216 0 119.394531 96.621094 216 216 216 119.394531 0 216-96.621094 216-216zm0 0"/></svg>--}}
                {{--                        <p class="exp-prg">--}}
                {{--                            {{ $course->countThemes() }} тем <br>({{ $course->completeCount(Auth::user()->id) }} выполнено)--}}
                {{--                        </p>--}}
                {{--                        @if ($course->hours)--}}
                {{--                        <svg style="--}}
                {{--                        width: 26px;--}}
                {{--                        height: 26px;--}}
                {{--                        margin-right: 10px;--}}
                {{--                        fill: #fabe4b;" height="512pt" viewBox="0 0 512 512" width="512pt" xmlns="http://www.w3.org/2000/svg"><path d="m369.164062 174.769531c7.8125 7.8125 7.8125 20.476563 0 28.285157l-134.171874 134.175781c-7.8125 7.808593-20.472657 7.808593-28.285157 0l-63.871093-63.875c-7.8125-7.808594-7.8125-20.472657 0-28.28125 7.808593-7.8125 20.472656-7.8125 28.28125 0l49.730468 49.730469 120.03125-120.035157c7.8125-7.808593 20.476563-7.808593 28.285156 0zm142.835938 81.230469c0 141.503906-114.515625 256-256 256-141.503906 0-256-114.515625-256-256 0-141.503906 114.515625-256 256-256 141.503906 0 256 114.515625 256 256zm-40 0c0-119.394531-96.621094-216-216-216-119.394531 0-216 96.621094-216 216 0 119.394531 96.621094 216 216 216 119.394531 0 216-96.621094 216-216zm0 0"/></svg>--}}
                {{--                        <p class="exp-prg">--}}
                {{--                            {{ $course->hours }} часов <br>обучения--}}
                {{--                        </p>--}}
                {{--                        @endif--}}
                {{--                        <div class="courses__expert expert row">--}}
                {{--                            <div class="expert__txt">--}}
                {{--                                <div>--}}
                {{--                                    учитель--}}
                {{--                                </div>--}}
                {{--                                <p>--}}
                {{--                                    {{ $course->user->name }}--}}
                {{--                                </p>--}}
                {{--                            </div>--}}
                {{--                            <img src="{{ $course->user->img_url ? $course->user->img_url : ('/images/default-avatar.jpg') }}" alt="courses"--}}
                {{--                                 class="img-responsive mx-auto d-block">--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--            </div>--}}
                {{--        </div>--}}
                {{--        @endforeach--}}
                @foreach ($courses as $course)
                    <div class="progress row" style="margin-left: 0">
                        <line-progress :percent="{{ $course->completePercent(Auth::user()->id) }}"></line-progress>
                    </div>
                    <div class="courses__block">
                        <button
                            type="button" data-toggle="collapse" data-target=".multi-collapse-0" aria-expanded="false"
                            aria-controls="multiCollapseImg0 multiCollapseText0 multiCollapseInfo0"
                            id="button_hide_course_info_0" style="background-color: white" class="person__btn btn-hide">
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
                        <div class="collapse multi-collapse-0 only_mobile" id="multiCollapseImg0">
                            <div class="courses__img col-md-4 col-lg-3">
                                <img onclick="location.href='{{ route('course.show.user', $course['id']) }}'"
                                     style="object-fit: cover; cursor:pointer"
                                     src="{{ $course->img_url ? $course->img_url : ('/images/math.jpg')  }}"
                                     alt="courses">
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
                                <div class="collapse multi-collapse-0 only_mobile" id="multiCollapseText0">
                                    <div class="courses__txt col-md-10">
                                        {{ $course->description }}
                                    </div>
                                </div>
                                <div class="collapse multi-collapse-0 only_mobile" id="multiCollapseInfo0">
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
                                        {{ $course->countThemes() }} тем
                                        <br>({{ $course->completeCount(Auth::user()->id) }}
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
        @else
            <h3 style="margin: 15px 0;">По запросу ничего не найдено...</h3>
        @endif
        <div class="w100 d-flex justify-content-center mt-2">
            {{ $courses->links() }}
        </div>
    </section>
    @include('partials.footer')
@endsection
