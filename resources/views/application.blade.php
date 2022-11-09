@extends('layouts.main_layout')

@section('content')
    @include('partials.header')
    <section id="application" class="account">
        <div class="container">
        <div class="application__block">
              <form method="POST" action="{{ route('application.send.guest') }}" class="auth-block">
               @csrf
                 <p class="form-title">
                    Отправить заявку
                 </p>
                 <div class="row">
                    <div class="form-group">
                       <label>ФИО</label>
                       <input value="{{ old('name') }}" name="name" type="text" class="form-control @error('name') is-invalid @enderror">
                       @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                 </div>
                 <div class="row">
                    <div class="form-group">
                       <label>Класс</label>
                       <input value="{{ old('grade') }}" name="grade" type="text" class="form-control @error('grade') is-invalid @enderror">
                       @error('grade')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                 </div>
                 <div class="row">
                    <div class="form-group">
                       <label>Электронная почта</label>
                       <input value="{{ old('email') }}" name="email" type="text" class="form-control @error('email') is-invalid @enderror">
                       @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                 </div>
                 <div class="row">
                    <div class="form-group">
                       <label>Телефон представителя</label>
                       <input value="{{ old('phone') }}" name="phone" type="text" class="form-control @error('phone') is-invalid @enderror">
                       @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                 </div>
                 <div class="row">
                 <button class="form-btn" type="submit" :disabled="!formReady"><a>Отправить заявку</a></button>
                 </div>
                 <div class="form-txt">
                    Нажимая кнопку «Отправить заявку» пользователь соглашается с <a href="#">политикой конфеденциальности</a> и <a href="#">правилами сайта</a>
                 </div>
              </form>
           </div>
        </div>
    </section>
    @include('partials.footer')
@endsection
