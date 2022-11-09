@extends('layouts.main_layout')

@section('content')
@include('partials.header')
<section id="gratitude" class="account">
    <div class="container" id="app">
        <div class="gratitude__block">
            <div class="auth-block gratitude-block">
                <p class="form-title">
                    Спасибо!
                </p>
                <div class="gratitude-txt">
                    На Вашу почту отправлена ссылка <br>на восстановление пароля!
                </div>
            </div>
        </div>
    </div>
</section>
 @include('partials.footer')
@endsection
