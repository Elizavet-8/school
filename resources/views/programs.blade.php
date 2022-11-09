@extends('layouts/base')

@section('content')
<section id="build">
   <div class="container">
      <div class="blue__block">
         <img class="build__img" src="{{ ('images/landing/choice1.png') }}" alt="capability">
         <h3 class="third__title">
            Собери свою программу и
            метод обучения <span>сам</span>
         </h3>
         <button class="blocks__btn btn-orange btn-custom">
            Записаться
         </button>
      </div>
      <h2 class="title__second">
         Из чего состоит программа <span>обучения:</span>
      </h2>
      <build-programs></build-programs>
   </div>
</section>
<section id="register">
   <div class="container">
      <h2 class="title__second">
         Хотите учиться в нашей школе?
         <span class="small">
            Заполните анкету, для того, чтобы зачислиться 
         </span>
      </h2>
      <div class="register__block">
      <register></register>
      <img class="register__img" src="{{ ('images/landing/form-img.png') }}" alt="capability">
      </div>
   </div>
</section>
<section id="questions-build" class="questions-section">
   <div class="container">
      <div class="questions__block">
         <div class="questions__txts">
            <h3 class="questions__title">
               Нужна<br>
               консультация?
            </h3>
            <div class="questions__caption">
               Оставьте заявку и мы свяжемся с вами
            </div>
         </div>
         <call-form></call-form>
      </div>
   </div>
</section>
@endsection