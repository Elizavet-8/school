@extends('layouts.main_layout')

@section('content')
    @include('partials.header')
    <section id="structure" class="account">
        <div id="app" class="container">
            @include('partials.section_top', ['theme' => $theme])
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
                            @if ($theme->is_videos($section['id']))
                                <a href="{{ route('theme.video', [$theme['id'], $section['id']]) }}">Видео-урок по
                                    теме</a>
                            @endif
                            @if ($theme->is_presentations($section['id']))
                                <a href="{{ route('theme.presentations', [$theme['id'], $section['id']]) }}">Презентация
                                    по теме</a>
                            @endif
                            <a href="{{ route('theme.materials', [$theme['id'], $section['id']]) }}">Дополнительные
                                материалы по теме</a>
                            @if ($theme->is_tests($section['id']))
                                <a class="menu_active_tab"
                                   href="{{ route('theme.test', [$theme['id'], $section['id']]) }}">Тесты по теме</a>
                            @endif
                            <a href="{{ route('all.theme.practicals', $theme['id']) }}">Практичекие
                                работы</a>
                        </nav>
                    </div>
                    <div class="offset-lg-1 col-lg-7 materials-block">
                        <p class="tests-title">
                            {{$section->title}}.Тесты по теме
                        </p>
                        <div class="materials-list">
                            <div style="margin-left:0; margin-right:0" class="row">
                                @foreach ($tests as $test)
                                    <div class="col-md-4">
                                        <a class="materials-item">
                                            <div style="display: flex; justify-content: space-between;">
                                                <svg
                                                    style="fill: #fabe4b; height:40px; min-height: 50px;align-self: flex-start;"
                                                    version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                    viewBox="0 0 511 511" style="enable-background:new 0 0 511 511;"
                                                    xml:space="preserve">
                                   <g>
                                       <path d="M415.5,40H351v-0.5c0-8.547-6.953-15.5-15.5-15.5H295v-0.5C295,10.542,284.458,0,271.5,0h-32
                                       C226.542,0,216,10.542,216,23.5V24h-40.5c-8.547,0-15.5,6.953-15.5,15.5V40H95.5C73.72,40,56,57.72,56,79.5v392
                                       c0,21.78,17.72,39.5,39.5,39.5h320c21.78,0,39.5-17.72,39.5-39.5v-392C455,57.72,437.28,40,415.5,40z M343.498,87H407.5
                                       c0.276,0,0.5,0.224,0.5,0.5v376c0,0.276-0.224,0.5-0.5,0.5h-304c-0.276,0-0.5-0.224-0.5-0.5v-376c0-0.276,0.224-0.5,0.5-0.5h64.001
                                       c0.089,0,0.175-0.01,0.263-0.013C174.967,96.695,186.51,103,199.5,103h112c12.99,0,24.533-6.305,31.736-16.013
                                       C343.324,86.99,343.41,87,343.498,87z M231,23.5c0-4.687,3.813-8.5,8.5-8.5h32c4.687,0,8.5,3.813,8.5,8.5V24h-49V23.5z M175,39.5
                                       c0-0.276,0.224-0.5,0.5-0.5h160c0.276,0,0.5,0.224,0.5,0.5v7.942c0,0.02-0.003,0.039-0.003,0.058S336,47.539,336,47.558V63.5
                                       c0,13.509-10.991,24.5-24.5,24.5h-112C185.991,88,175,77.009,175,63.5V39.5z M440,471.5c0,13.509-10.991,24.5-24.5,24.5h-320
                                       C81.991,496,71,485.009,71,471.5v-392C71,65.991,81.991,55,95.5,55H160v8.5c0,2.918,0.328,5.76,0.931,8.5H103.5
                                       C94.953,72,88,78.953,88,87.5v376c0,8.547,6.953,15.5,15.5,15.5h304c8.547,0,15.5-6.953,15.5-15.5v-376
                                       c0-8.547-6.953-15.5-15.5-15.5h-57.431c0.604-2.74,0.931-5.582,0.931-8.5V55h64.5c13.509,0,24.5,10.991,24.5,24.5V471.5z"/>
                                       <path d="M144.5,215h62c4.687,0,8.5-3.813,8.5-8.5v-62c0-4.687-3.813-8.5-8.5-8.5h-62c-4.687,0-8.5,3.813-8.5,8.5v62
                                       C136,211.187,139.813,215,144.5,215z M151,151h49v49h-49V151z"/>
                                       <path d="M206.5,344h-62c-4.687,0-8.5,3.813-8.5,8.5v62c0,4.687,3.813,8.5,8.5,8.5h62c4.687,0,8.5-3.813,8.5-8.5v-62
                                       C215,347.813,211.187,344,206.5,344z M200,408h-49v-49h49V408z"/>
                                       <path d="M218.197,242.197l-5.392,5.392c-2.707-4.535-7.65-7.589-13.305-7.589h-48c-8.547,0-15.5,6.953-15.5,15.5v48
                                       c0,8.547,6.953,15.5,15.5,15.5h48c8.547,0,15.5-6.953,15.5-15.5v-8c0-4.142-3.358-7.5-7.5-7.5s-7.5,3.358-7.5,7.5v8
                                       c0,0.276-0.224,0.5-0.5,0.5h-48c-0.276,0-0.5-0.224-0.5-0.5v-48c0-0.276,0.224-0.5,0.5-0.5h48c0.276,0,0.5,0.224,0.5,0.5v4.894
                                       l-16.5,16.5l-10.697-10.697c-2.929-2.929-7.678-2.929-10.606,0c-2.929,2.929-2.929,7.677,0,10.606l16,16
                                       c1.464,1.465,3.384,2.197,5.303,2.197s3.839-0.732,5.303-2.197l23.999-23.999c0.001-0.001,0.002-0.002,0.002-0.002l15.999-15.999
                                       c2.929-2.929,2.929-7.677,0-10.606C225.875,239.268,221.125,239.268,218.197,242.197z"/>
                                       <path
                                           d="M239.5,159h24c4.142,0,7.5-3.358,7.5-7.5s-3.358-7.5-7.5-7.5h-24c-4.142,0-7.5,3.358-7.5,7.5S235.358,159,239.5,159z"/>
                                       <path d="M232,183.5c0,4.142,3.358,7.5,7.5,7.5h120c4.142,0,7.5-3.358,7.5-7.5s-3.358-7.5-7.5-7.5h-120
                                       C235.358,176,232,179.358,232,183.5z"/>
                                       <path
                                           d="M239.5,271h80c4.142,0,7.5-3.358,7.5-7.5s-3.358-7.5-7.5-7.5h-80c-4.142,0-7.5,3.358-7.5,7.5S235.358,271,239.5,271z"/>
                                       <path
                                           d="M359.5,288h-120c-4.142,0-7.5,3.358-7.5,7.5s3.358,7.5,7.5,7.5h120c4.142,0,7.5-3.358,7.5-7.5S363.642,288,359.5,288z"/>
                                       <path
                                           d="M239.5,375h32c4.142,0,7.5-3.358,7.5-7.5s-3.358-7.5-7.5-7.5h-32c-4.142,0-7.5,3.358-7.5,7.5S235.358,375,239.5,375z"/>
                                       <path
                                           d="M359.5,392h-120c-4.142,0-7.5,3.358-7.5,7.5s3.358,7.5,7.5,7.5h120c4.142,0,7.5-3.358,7.5-7.5S363.642,392,359.5,392z"/>
                                   </g>
                              </svg>
                                                @if ($test->passed(Auth::user()->id))
                                                    <i class="fa fa-2x fa-check-circle" style="color: rgb(86, 197, 21)"
                                                       aria-hidden="true"></i>
                                                @endif

                                            </div>
                                            <div class="materials-txt">
                                                <p
                                                    onclick="location.href='/test/about/{{$test->id}}'"
                                                    style="cursor: pointer">
                                                    {{$test->order}}. {{ $test->title }}
                                                </p>
                                                @if ($test->is_required)
                                                    <div style="color: red; font-size: 14px;">(контрольный)</div>
                                                @endif
                                            </div>
                                        </a>
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
