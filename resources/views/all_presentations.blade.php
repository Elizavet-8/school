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
                     <a class="menu_active_tab" href="{{ route('all.theme.presentations', [$theme['id']]) }}">Презентация по теме</a>
                     @endif
                     <a  href="{{ route('all.theme.materials', [$theme['id']]) }}">Дополнительные материалы по теме</a>
                     @if ($theme->testsCount > 0)
                     <a href="{{ route('all.theme.test', [$theme['id']]) }}">Тесты по теме</a>
                     @endif
                         <a href="{{ route('all.theme.practicals', $theme['id']) }}">Практичекие
                             работы</a>
                    </nav>
                 </div>
                 <div class="offset-lg-1 col-lg-7 materials-block">
                     <p class="tests-title">
                        Презентация по теме
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
