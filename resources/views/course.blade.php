@extends('layouts.main_layout')

@section('content')
    @include('partials.header')
    <section id="structure" class="account">
        <div class="container" id="app">
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
                <div class="account-elem">
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
                        {{ $course->countThemes() }} тем <br>({{ $course->completeCount(Auth::user()->id) }} выполнено)
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
                            alt="person">
                    </div>
                </div>
            </div>
            <h2 style="margin-bottom: 0;">
                <b>курс: </b>{{ $course->title }}
            </h2>
        </div>
    </section>
    <section id="chapter">
        <div class="container">
            <div class="chapter__block">
                <div class="row">
                    <div class="col-md-12">
                        <div class="chapter-accordion" style="margin:0">
                            @foreach($course->chapters as $chapter)
                                @foreach ($chapter->themes()->orderBy("order", "ASC")->get() as $theme)
                                    <div class="trigger" style="border-radius: 0;">
                                        @if ($loop->iteration == 1)
                                            <p class="trigger-title" style="margin: 25px 0 0 0;">

                                                Модуль {{$chapter->order}} {{ $chapter->title }}

                                            </p>
                                        @endif
                                        <div class="trigger-elem">
                                            <input class="trigger-checkbox" type="checkbox" id="checkbox-{{ $theme->id }}" name="checkbox-1"/>
                                            <label class="trigger-label checkbox" for="checkbox-{{ $theme->id }}">
                                                <div class="checkbox-img
                                        @if ($theme->complete(Auth::user()->id))
                                                    checkbox-img-passed
@endif
                                                    ">
                                                    <img src="{{ asset('icons/tick.png') }}" alt="courses">
                                                    <img src="{{ asset('icons/tick-hover.png') }}" alt="courses">
                                                </div>
                                                <span class="title">{{$theme->order}}. {{ $theme->title }}</span>
                                                <div class="icon-holder">

                                                    <a title="Документы"
                                                       href="{{ route('all.theme.materials', [$theme['id']]) }}"
                                                       class="ml-3">
                                                        <i style="color:#fabe4b" class="far fa-file fa-lg"></i></a>
                                                    @if ( $theme->videosCount > 0)
                                                        <a title="Видео"
                                                           href="{{ route('all.theme.video', [$theme['id']]) }}"
                                                           class="ml-3">
                                                            <i style="color:#fabe4b" class="fas fa-video fa-lg"></i></a>
                                                    @endif
                                                    @if ( $theme->presentationsCount > 0)
                                                        <a title="Презентации"
                                                           href="{{ route('all.theme.presentations', [$theme['id']]) }}"
                                                           class="ml-3">
                                                            <i style="color:#fabe4b"
                                                               class="far fa-file-powerpoint fa-lg"></i></a>
                                                    @endif
                                                    @if ( $theme->testsCount > 0)
                                                        <a title="Тесты"
                                                           href="{{ route('all.theme.test', [$theme['id']]) }}"
                                                           class="ml-3">
                                                            <i style="color:#fabe4b" class="fas fa-tasks fa-lg"></i></a>
                                                    @endif
                                                    <a title="Расписание"
                                                       href="https://eschool.rosvuz.ru/pupil/schedules" class="ml-3">
                                                        <i style="color:#fabe4b" class="fas fa-calendar-alt fa-lg"></i></a>
                                                    <a title="Отзывы" href="{{ route('theme.menu', $theme['id']) }}"
                                                       class="ml-3">
                                                        <i style="color:#fabe4b" class="fas fa-comment fa-lg"></i></a>
                                                    <a title="Практика"
                                                       href="{{ route('all.theme.practicals', $theme['id']) }}"
                                                       class="ml-3">
                                                        <svg  class="svg-inline--fa practicals-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                             width="661.543px" height="661.544px" viewBox="0 0 661.543 661.544" style="enable-background:new 0 0 661.543 661.544;"
                                                             xml:space="preserve">
		<path d="M628.351,389.866l-49.869-49.868c-6.797-6.798-14.244-10.038-22.989-10.038c-7.447,0-14.196,2.963-20.075,8.746
			l-39.824,39.182L336.599,536.876c-2.915,3.564-4.407,6.507-4.856,8.096l-26.555,94.225c-0.552,1.969-0.967,3.883-0.967,5.831
			c0,8.096,7.771,16.517,17.809,16.517c2.266,0,3.896-0.276,5.181-0.649l93.583-27.203c3.171-0.919,5.823-1.948,7.771-3.883
			l159.962-159.637l39.175-39.183c5.181-5.181,8.097-11.66,9.07-19.425C636.772,402.819,633.857,395.372,628.351,389.866z
			 M406.867,601.313l-58.932,16.517l17.159-58.932l143.127-143.127l42.415,41.772L406.867,601.313z M575.892,432.281l-42.415-41.772
			l22.665-22.665l41.772,41.772L575.892,432.281z"/>
                                                            <path d="M383.552,311.502H105.078c-10.038,0-17.809,7.771-17.809,17.809s7.771,18.133,17.809,18.133h278.475
			c10.037,0,17.809-8.096,17.809-18.133S393.589,311.502,383.552,311.502z"/>
                                                            <path d="M401.361,409.616c0-10.037-7.771-17.809-17.809-17.809H105.078c-10.038,0-17.809,7.771-17.809,17.809
			s7.771,18.134,17.809,18.134h278.475C393.589,427.75,401.361,419.653,401.361,409.616z"/>
                                                            <path d="M234.278,471.464h-129.2c-10.038,0-17.809,7.771-17.809,17.809s7.771,17.809,17.809,17.809h129.2
			c10.037,0,18.133-7.771,18.133-17.809S244.315,471.464,234.278,471.464z"/>
                                                            <path d="M234.278,551.77h-129.2c-10.038,0-17.809,7.771-17.809,17.809s7.771,17.809,17.809,17.809h129.2
			c10.037,0,18.133-7.771,18.133-17.809S244.315,551.77,234.278,551.77z"/>
                                                            <path d="M60.714,622.68V38.857c0-2.266,0.974-3.24,3.24-3.24h132.765v192.346c0,22.022,16.835,39.832,38.851,39.832h192.346v108.8
			h35.942v-108.8v-35.942h-0.649L232.336,0.649L231.687,0h-34.968H63.954C52.943,0,43.555,3.882,36.108,11.336
			c-7.454,7.447-11.336,16.835-11.336,27.521V622.68c0,22.022,17.16,38.857,39.182,38.857h211.447V625.92H63.954
			C61.688,625.92,60.714,624.952,60.714,622.68z M232.336,51.485l180.361,180.361H235.569c-2.266,0-3.233-1.299-3.233-3.882V51.485
			L232.336,51.485z"/>
</svg>
                                                    </a>
                                                </div>
                                            </label>
                                            <div class="content">
                                                <p class="content-caption">Содержимое</p>
                                                <div class="content-elem">
                                                    <div class="content-left">
                                                        <svg style="margin: 20px 12px 20px 0;" fill="#fabe4b"
                                                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50"
                                                             width="24px" height="28px">
                                                            <path
                                                                d="M 7 2 L 7 48 L 43 48 L 43 14.59375 L 42.71875 14.28125 L 30.71875 2.28125 L 30.40625 2 Z M 9 4 L 29 4 L 29 16 L 41 16 L 41 46 L 9 46 Z M 31 5.4375 L 39.5625 14 L 31 14 Z M 15 22 L 15 24 L 35 24 L 35 22 Z M 15 28 L 15 30 L 31 30 L 31 28 Z M 15 34 L 15 36 L 35 36 L 35 34 Z"/>
                                                        </svg>
                                                        <p>
                                                            Материалы по теме
                                                        </p>
                                                    </div>
                                                    <div class="content-right">
                                                        <button
                                                            style="margin-left: 20px"
                                                            onclick="location.href='{{ route('theme.menu', $theme['id']) }}'"
                                                            class="btn-active">
                                                            <div style="font-size: 12px;color: #000;">Перейти</div>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('partials.footer')
@endsection
