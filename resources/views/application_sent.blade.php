@extends('layouts.main_layout')

@section('content')
    @include('partials.header')
    <section id="application" class="account">
        <div class="container">
            <div class="gratitude__block">
                <div class="auth-block gratitude-block">
                    <p class="form-title">
                        Спасибо!
                    </p>
                    <div class="gratitude-txt">
                        Ваша заявка принята и будет рассмотрена <br>администратором системы в течение 24 часов.
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('partials.footer')
@endsection
