<!doctype html>
<html lang="ru">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Росвуз</title>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@500&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

   <link rel="stylesheet" href="{{mix('/css/app.css')}}">
</head>

<body>
   <div class="wrapper">
      <main class="main">
         <section id="admission">
         <img class="admission__img" src="{{ ('images/landing/entrance3.png') }}" alt="capability">
            <div class="admission__block">
               <header class="header admission__header">
                  <div class="head__row">
                     <div class="burger">
                        <span></span>
                        <span></span>
                     </div>
                     <nav class="nav" id="nav">
                        <div class="close-nav">
                           <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <rect y="20.5059" width="29" height="3" transform="rotate(-45 0 20.5059)" fill="#14134F" />
                              <rect x="2.12109" width="29" height="3" transform="rotate(45 2.12109 0)" fill="#14134F" />
                           </svg>
                        </div>
                        <div class="menu__show">
                           <ul class="main">
                              <li><a href="/" onclick="location.href='{{ url('/') }}'">Главная</a></li>
                              <li><a @if (url()->current() != url('/'))
                                    onclick="location.href='{{ url('/').'#capability' }}'"
                                    @endif
                                    href="#capability">О платформе</a></li>

                              <li><a @if (url()->current() != url('/'))
                                    onclick="location.href='{{ url('/').'#program' }}'"
                                    @endif
                                    href="#program">Программы</a></li>
                              <li><a a href="/" onclick="location.href='{{ url('/').'#questions' }}'">Контакты</a></li>
                              <div id="indicator"></div>
                           </ul>
                        </div>
                     </nav>
                     <div class="overlay"></div>
                  </div>
               </header>
               <div class="admission__links">
                  <a href="https://eschool.rosvuz.ru" class="admission__link">
                     Вход на цифровую платформу РосВуз
                  </a>
                  <a href="/login" class="admission__link">
                     Вход в систему дистанционного образования РосВуз
                  </a>
               </div>
            </div>
         </section>
      </main>
   </div>
   <script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
   <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
   <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script>
   <script src="{{ asset('js/app.js') }}"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>