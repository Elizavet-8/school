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
                            @if ($theme->is_videos($section['id']))
                                <a class="menu_active_tab"
                                   href="{{ route('theme.video', [$theme['id'], $section['id']]) }}">Видео-урок по
                                    теме</a>
                            @endif
                            @if ($theme->is_presentations($section['id']))
                                <a href="{{ route('theme.presentations', [$theme['id'], $section['id']]) }}">Презентация
                                    по теме</a>
                            @endif
                            <a href="{{ route('theme.materials', [$theme['id'], $section['id']]) }}">Дополнительные
                                материалы по теме</a>
                            @if ($theme->tests->where('section_id', $section['id'])->count() > 0)
                                <a href="{{ url("/test/about/{$theme->tests->where('section_id', $section['id'])[0]['id']}")}}">Тест
                                    по теме</a>
                            @endif
                            <a href="{{ route('all.theme.practicals', $theme['id']) }}">Практичекие
                                работы</a>
                        </nav>
                    </div>
                    <div class="offset-lg-1 col-lg-7 materials-block">
                        <p class="tests-title">
                            {{$section->title}}. Видео-урок по теме
                        </p>
                        @if (count($materials) == 1)
                            @foreach ($materials as $file)

                                <div style="position:relative;">
                                    <div class="shadow" id="shadow-{{$file->id}}">
                                        <div class="video-play-button">
                                            <svg style="fill:#fabe4b; margin-left:5px" height="30px" version="1.1"
                                                 id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                 viewBox="0 0 494.148 494.148"
                                                 style="enable-background:new 0 0 494.148 494.148;"
                                                 xml:space="preserve">
                           <g>
                               <g>
                                   <path d="M405.284,201.188L130.804,13.28C118.128,4.596,105.356,0,94.74,0C74.216,0,61.52,16.472,61.52,44.044v406.124
                                    c0,27.54,12.68,43.98,33.156,43.98c10.632,0,23.2-4.6,35.904-13.308l274.608-187.904c17.66-12.104,27.44-28.392,27.44-45.884
                                    C432.632,229.572,422.964,213.288,405.284,201.188z"/>
                               </g>
                           </g>
                           </svg>
                                        </div>
                                    </div>
                                    <iframe id="video-{{$file->id}}" style="border-radius: 10px;" class="mb-3"
                                            height="315px" width="100%" src="{{$file->url}}"
                                            title="YouTube video player" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen></iframe>
                                </div>

                            @endforeach
                        @endif
                        @if (count($materials) > 1)
                            <div class="row">
                                @foreach ($materials as $file)

                                    <div
                                        class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12 d-flex justify-content-center align-items-center">

                                        <div data-toggle="modal" data-target="#video-modal-{{$file->id}}"
                                             class="youtube-container" style="position:relative;">
                                            <div class="shadow-three">
                                                <div class="video-play-button">
                                                    <svg style="fill:#fabe4b; margin-left:5px" height="30px"
                                                         version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                         viewBox="0 0 494.148 494.148"
                                                         style="enable-background:new 0 0 494.148 494.148;"
                                                         xml:space="preserve">
                           <g>
                               <g>
                                   <path d="M405.284,201.188L130.804,13.28C118.128,4.596,105.356,0,94.74,0C74.216,0,61.52,16.472,61.52,44.044v406.124
                                    c0,27.54,12.68,43.98,33.156,43.98c10.632,0,23.2-4.6,35.904-13.308l274.608-187.904c17.66-12.104,27.44-28.392,27.44-45.884
                                    C432.632,229.572,422.964,213.288,405.284,201.188z"/>
                               </g>
                           </g>
                           </svg>
                                                </div>
                                            </div>
                                            <iframe style="border-radius: 10px;" class="mb-3 youtube-frame"
                                                    src="{{$file->url}}" title="YouTube video player" frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                    allowfullscreen></iframe>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.footer')

    @if (count($materials) > 1)
        @foreach ($materials as $file)
            <!-- Modal -->
            <div class="modal fade" id="video-modal-{{$file->id}}" tabindex="-1" role="dialog"
                 aria-labelledby="videoModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-video" role="document">
                    <div class="modal-content modal-content-video">
                        <div class="modal-header">
                            <h5 class="modal-title" id="videoModalLabel">{{$file->title}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="position:relative;">
                                <div class="shadow-modal" id="shadow-{{$file->id}}">
                                    <div class="video-play-button">
                                        <svg style="fill:#fabe4b; margin-left:5px" height="30px" version="1.1"
                                             id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             viewBox="0 0 494.148 494.148"
                                             style="enable-background:new 0 0 494.148 494.148;" xml:space="preserve">
                           <g>
                               <g>
                                   <path d="M405.284,201.188L130.804,13.28C118.128,4.596,105.356,0,94.74,0C74.216,0,61.52,16.472,61.52,44.044v406.124
                                    c0,27.54,12.68,43.98,33.156,43.98c10.632,0,23.2-4.6,35.904-13.308l274.608-187.904c17.66-12.104,27.44-28.392,27.44-45.884
                                    C432.632,229.572,422.964,213.288,405.284,201.188z"/>
                               </g>
                           </g>
                           </svg>
                                    </div>
                                </div>
                                <iframe id="video-{{$file->id}}" style="border-radius: 10px;"
                                        class="mb-3 youtube-frame-modal" src="{{$file->url}}"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection
