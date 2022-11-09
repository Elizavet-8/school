<!doctype html>
<html lang="ru">
@section('head')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>Росвуз</title>
    <link rel="icon" href="{{ asset('/icons/circle-solid.png') }}" type="image/png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@500&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{mix('/css/app.css')}}">
</head>
@show

<body>
   <div class="wrapper">
      @section('header')
      <header class="header">
            <div class="container">
                <div class="head__row">
                    <a href="/">
                        <svg class="logo" viewBox="0 0 71 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.31513 9.552V12H0.323125V0.799999H9.10713V3.248H3.45913V5.136H8.43513V7.504H3.45913V9.552H9.31513ZM10.4086 6.272H15.0806V8.608H10.4086V6.272ZM19.9718 12.144C19.2464 12.144 18.5318 12.064 17.8278 11.904C17.1238 11.7333 16.5584 11.5147 16.1318 11.248L17.0438 9.168C17.4384 9.41333 17.9078 9.61067 18.4518 9.76C18.9958 9.89867 19.5344 9.968 20.0677 9.968C20.5584 9.968 20.9051 9.92 21.1078 9.824C21.3211 9.71733 21.4278 9.568 21.4278 9.376C21.4278 9.184 21.2998 9.05067 21.0438 8.976C20.7984 8.89067 20.4038 8.81067 19.8598 8.736C19.1664 8.65067 18.5744 8.53867 18.0838 8.4C17.6038 8.26133 17.1878 8.00533 16.8358 7.632C16.4838 7.25867 16.3078 6.736 16.3078 6.064C16.3078 5.50933 16.4731 5.01867 16.8038 4.592C17.1344 4.15467 17.6144 3.81333 18.2438 3.568C18.8838 3.312 19.6464 3.184 20.5318 3.184C21.1611 3.184 21.7851 3.248 22.4038 3.376C23.0224 3.504 23.5398 3.68533 23.9558 3.92L23.0438 5.984C22.2758 5.55733 21.4438 5.344 20.5477 5.344C20.0678 5.344 19.7158 5.40267 19.4918 5.52C19.2678 5.62667 19.1558 5.77067 19.1558 5.952C19.1558 6.15467 19.2784 6.29867 19.5238 6.384C19.7691 6.45867 20.1744 6.53867 20.7398 6.624C21.4544 6.73067 22.0464 6.85333 22.5158 6.992C22.9851 7.13067 23.3904 7.38667 23.7318 7.76C24.0838 8.12267 24.2598 8.63467 24.2598 9.296C24.2598 9.84 24.0944 10.3307 23.7638 10.768C23.4331 11.1947 22.9424 11.5307 22.2918 11.776C21.6518 12.0213 20.8784 12.144 19.9718 12.144ZM30.0018 12.144C29.0418 12.144 28.1831 11.952 27.4258 11.568C26.6684 11.184 26.0764 10.6507 25.6497 9.968C25.2338 9.28533 25.0258 8.512 25.0258 7.648C25.0258 6.784 25.2338 6.016 25.6497 5.344C26.0764 4.66133 26.6684 4.13333 27.4258 3.76C28.1831 3.376 29.0418 3.184 30.0018 3.184C30.9831 3.184 31.8311 3.39733 32.5458 3.824C33.2604 4.24 33.7671 4.82133 34.0658 5.568L31.7138 6.768C31.3191 5.98933 30.7431 5.6 29.9858 5.6C29.4418 5.6 28.9884 5.78133 28.6258 6.144C28.2738 6.50667 28.0978 7.008 28.0978 7.648C28.0978 8.29867 28.2738 8.81067 28.6258 9.184C28.9884 9.54667 29.4418 9.728 29.9858 9.728C30.7431 9.728 31.3191 9.33867 31.7138 8.56L34.0658 9.76C33.7671 10.5067 33.2604 11.0933 32.5458 11.52C31.8311 11.936 30.9831 12.144 30.0018 12.144ZM40.8271 3.184C41.9045 3.184 42.7685 3.504 43.4191 4.144C44.0805 4.784 44.4111 5.74933 44.4111 7.04V12H41.3711V7.536C41.3711 6.352 40.8965 5.76 39.9471 5.76C39.4245 5.76 39.0031 5.93067 38.6831 6.272C38.3738 6.61333 38.2191 7.12533 38.2191 7.808V12H35.1791V0.127999H38.2191V4.128C38.5498 3.81867 38.9391 3.584 39.3871 3.424C39.8351 3.264 40.3151 3.184 40.8271 3.184ZM50.7968 12.144C49.8688 12.144 49.0314 11.952 48.2848 11.568C47.5381 11.184 46.9514 10.6507 46.5247 9.968C46.1088 9.28533 45.9008 8.512 45.9008 7.648C45.9008 6.79467 46.1088 6.02667 46.5247 5.344C46.9514 4.66133 47.5328 4.13333 48.2688 3.76C49.0154 3.376 49.8581 3.184 50.7968 3.184C51.7354 3.184 52.5781 3.376 53.3248 3.76C54.0714 4.13333 54.6528 4.66133 55.0688 5.344C55.4848 6.016 55.6928 6.784 55.6928 7.648C55.6928 8.512 55.4848 9.28533 55.0688 9.968C54.6528 10.6507 54.0714 11.184 53.3248 11.568C52.5781 11.952 51.7354 12.144 50.7968 12.144ZM50.7968 9.728C51.3301 9.728 51.7674 9.54667 52.1088 9.184C52.4501 8.81067 52.6208 8.29867 52.6208 7.648C52.6208 7.008 52.4501 6.50667 52.1088 6.144C51.7674 5.78133 51.3301 5.6 50.7968 5.6C50.2634 5.6 49.8261 5.78133 49.4848 6.144C49.1434 6.50667 48.9728 7.008 48.9728 7.648C48.9728 8.29867 49.1434 8.81067 49.4848 9.184C49.8261 9.54667 50.2634 9.728 50.7968 9.728ZM61.453 12.144C60.525 12.144 59.6877 11.952 58.941 11.568C58.1943 11.184 57.6077 10.6507 57.181 9.968C56.765 9.28533 56.557 8.512 56.557 7.648C56.557 6.79467 56.765 6.02667 57.181 5.344C57.6077 4.66133 58.189 4.13333 58.925 3.76C59.6717 3.376 60.5143 3.184 61.453 3.184C62.3917 3.184 63.2343 3.376 63.981 3.76C64.7277 4.13333 65.309 4.66133 65.725 5.344C66.141 6.016 66.349 6.784 66.349 7.648C66.349 8.512 66.141 9.28533 65.725 9.968C65.309 10.6507 64.7277 11.184 63.981 11.568C63.2343 11.952 62.3917 12.144 61.453 12.144ZM61.453 9.728C61.9863 9.728 62.4237 9.54667 62.765 9.184C63.1063 8.81067 63.277 8.29867 63.277 7.648C63.277 7.008 63.1063 6.50667 62.765 6.144C62.4237 5.78133 61.9863 5.6 61.453 5.6C60.9197 5.6 60.4823 5.78133 60.141 6.144C59.7997 6.50667 59.629 7.008 59.629 7.648C59.629 8.29867 59.7997 8.81067 60.141 9.184C60.4823 9.54667 60.9197 9.728 61.453 9.728ZM67.7573 0.127999H70.7973V12H67.7573V0.127999Z" fill="#F2BF6F" />
                        </svg>
                    </a>
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
                                <li><a href="/">Главная</a></li>
                                <li><a 
                                    @if (url()->current() != url('/'))
                                    onclick="location.href='{{ url('/').'#capability' }}'" 
                                    @endif
                                    href="#capability">О платформе</a></li>
                               
                                <li><a 
                                    @if (url()->current() != url('/'))
                                    onclick="location.href='{{ url('/').'#program' }}'" 
                                    @endif
                                    href="#program">Программы</a></li>
                                <li><a href="#questions">Контакты</a></li>
                                <div id="indicator"></div>
                            </ul>
                            <div class="head__btn-block">
                                <button onclick="location.href='{{ url('/entrance') }}'" class="btn-blue btn-custom head__btn">Войти</button>
                            </div>
                        </div>
                    </nav>
                    <div class="head__elem">
                        <div class="head__phone">
                            <a class="head__phone-link" href="tel: +74992641111">+7 (499) 264-11-11</a>
                            <a href="#question_form" class="head__phone-btn btn-custom">Заказать обратный звонок</a>
                        </div>
                        <button onclick="location.href='{{ url('/entrance') }}'" class="btn-blue btn-custom head__btn">Войти</button>
                    </div>
                    <div class="overlay"></div>
                </div>
            </div>
        </header>
      @show

      <main class="main" id="app">
         @section('content')

         @show
      </main>

      @section('footer')
      <footer class="footer">
            <div class="container">
                <div class="footer__row">
                    <ul class="footer__list">
                        <li><a href="/">Главная</a></li>
                        <li><a 
                            @if (url()->current() != url('/'))
                            onclick="location.href='{{ url('/').'#capability' }}'" 
                            @endif
                            href="#capability">О платформе</a></li>
                        <li><a 
                            @if (url()->current() != url('/'))
                            onclick="location.href='{{ url('/').'#program' }}'" 
                            @endif
                            href="#program">Программы</a></li>
                        <li><a href="#questions">Контакты</a></li>
                    </ul>
                    <div class="footer__btns">
                        <a href="#" class="footer__lnk">
                            Политика конфеденциальности
                        </a>
                        <button onclick="location.href='{{ url('/entrance') }}'" class="btn-orange btn-custom footer__btn">Войти</button>
                    </div>
                </div>
            </div>
        </footer>
      @show

   </div>

   @section('footerScript')
   <script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
   <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
   <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script>
   <script src="{{ mix('js/app.js') }}"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
   @show
</body>

</html>