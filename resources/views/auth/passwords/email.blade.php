@extends('layouts.main_layout')

@section('content')
    @include('partials.header')
    <section id="recover" class="account">
        <div class="container" id="app">
            <div class="recover__block">
                <form method="POST" action="{{ route('password.email') }}" class="auth-block">
                    @csrf
                    <p class="form-title">Восстановление доступа
                    </p>
                    <div class="row">
                        <div class="form-group">
                            <label>Введите Ваш e-mail</label>
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror" name="email"
                                   value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
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
