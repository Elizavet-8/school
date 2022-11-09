@extends('layouts.main_layout')

@section('content')
    @include('partials.header')
    <section id="structure" class="account">
        <div class="container">
            @include('partials.test_top', ['theme' => $test->theme])
            <h2>
                <b>модуль: </b>{{ $test->theme->chapter->title }}
            </h2>
            <div id="pass" class="pass">
                <div style="margin-left:0; margin-right:0" class="row" id="app">
                    <div class="col-lg-4 pass-menu">
                        <p class="menu-title">
                            Тема: {{ $test->theme->title }}
                        </p>
                        <nav class="menu">
                            @if ($test->theme->is_videos($test->section['id']))
                            <a href="{{ route('theme.video', [$test->theme['id'], $test->section['id']]) }}">Видео-урок по теме</a>
                            @endif
                            @if ($test->theme->is_presentations($test->section['id']))
                            <a href="{{ route('theme.presentations', [$test->theme['id'], $test->section['id']]) }}">Презентация по теме</a>
                            @endif
                            <a  href="{{ route('theme.materials', [$test->theme['id'], $test->section['id']]) }}">Дополнительные материалы по теме</a>
                            @if ($test->theme->is_tests($test->section['id']))
                            <a class="menu_active_tab" href="{{ route('theme.test', [$test->theme['id'], $test->section['id']]) }}">Тесты по теме</a>
                            @endif
                           </nav>
                    </div>
                    <test
                            :test="{{ $test }}"
                            :questionscount="{{ $test->questions->count() }}"
                            :section="{{ $test->section }}"
                    ></test>
                </div>
            </div>
        </div>
    </section>
    @include('partials.footer')
@endsection
