@extends('layouts.main_layout')

@section('content')
    @include('partials.header')
    <section id="setting" class="account">
        <div class="container" id="app">
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
            <h2>
                Настройка профиля
            </h2>

            <user-profile :user="{{ Auth::user() }}"></user-profile>

        </div>
    </section>
    @include('partials.footer')
@endsection
