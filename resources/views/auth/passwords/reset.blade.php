@extends('layouts.main_layout')

@section('content')
    @include('partials.header')
    <section id="application" class="account">
        <div class="container" id="app">
            <div class="application__block">
                <form method="POST" action="{{ route('password.update') }}" class="auth-block">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">
                    <p class="form-title">
                        Сброс пароля
                    </p>
                    <div class="row">
                        <div class="form-group">
                            <label>e-mail</label>
                            <input readonly id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror" name="email"
                                   value="{{ $email }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label>Пароль</label>
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror" name="password"
                                   required autocomplete="new-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label>Подтверждение пароля</label>
                            <input id="password-confirm" type="password" class="form-control"
                                   name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>
                    <div class="row">
                        <button class="form-btn" type="submit">Отправить</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    @include('partials.footer')
@endsection
