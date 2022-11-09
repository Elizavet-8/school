@extends('layouts.main_layout')

@section('content')
    @include('partials.header')
    <section id="entrance" class="account">
        <div class="container" id="app">
            <div class="entrance__block">
                <form method="POST" action="{{ route('login.custom') }}" class="auth-block">
                    @csrf
                    <p class="form-title">
                        Авторизация
                    </p>

                    <div class="row">
                        <div class="form-group">
                            <label>Введите Вашу электронную почту</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label>Введите Ваш пароль</label>
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror" name="password" required
                                   autocomplete="current-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                            @enderror
                        </div>
                    </div>
                    <button class="form-btn" type="submit"><a>Войти</a></button>
                    <div class="form-txt">
                        Нажимая кнопку «Войти» пользователь соглашается с <a href="#">политикой конфеденциальности</a> и
                        <a href="#">правилами сайта</a>
                    </div>
                    <div class="form-links">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">
                                Восстановить пароль?
                            </a>
                        @endif
                        <a href="{{ route('application.create.guest') }}">Отправить заявку на получение доступа</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
    @include('partials.footer')
@endsection
