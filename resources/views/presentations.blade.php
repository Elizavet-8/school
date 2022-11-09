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
                     <a href="{{ route('theme.video', [$theme['id'], $section['id']]) }}">Видео-урок по теме</a>
                     @endif
                     @if ($theme->is_presentations($section['id']))
                     <a class="menu_active_tab" href="{{ route('theme.presentations', [$theme['id'], $section['id']]) }}">Презентация по теме</a>
                     @endif
                     <a href="{{ route('theme.materials', [$theme['id'], $section['id']]) }}">Дополнительные материалы по теме</a>
                     @if ($theme->tests->where('section_id', $section['id'])->count() > 0)
                     <a href="{{ url("/test/about/{$theme->tests->where('section_id', $section['id'])[0]['id']}")}}">Тест по теме</a>
                     @endif
                    </nav>
                 </div>
                 <div class="offset-lg-1 col-lg-7 materials-block">
                     <p class="tests-title">
                        {{$section->title}}. Презентация по теме
                     </p>
                     @foreach ($materials as $file)
                     <iframe src='https://view.officeapps.live.com/op/embed.aspx?src={{URL::to('/')}}{{$file->url}}' width='100%' height='315px' frameborder='0'></iframe>
                     @endforeach                  
                 </div>
              </div>
           </div>
        </div>
     </section>
    @include('partials.footer')
@endsection
