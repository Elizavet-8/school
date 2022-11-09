<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{ asset('/icons/circle-solid.png') }}" type="image/png">
        <title>{{ config('app.name', 'Laravel') }}</title>

        {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,300;0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.gstatic.com">

        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}}
        </style>
        <link rel="stylesheet" href="{{mix('/css/app.css')}}"> 
    </head>
    <body class="antialiased">
      <!-- HEADER -->
      {{-- <header>
         <div class="container">
            <div class="row">
               <div class="logotip col-md-5 col-sm-7 col-7">
                  <p>Система дистанционного обучения Росвуз</p>
               </div>
               <a href="/entrance" class="btn-active btn-exit text-center col-lg-3 col-3">
                  <p>
                     Выход <span>из личного кабинета</span>
                  </p>
                  <svg display="none">
                     <symbol viewBox="0 0 512 512" id="entrance">
                        <g>
                           <path d="M228.487,319.228c-7.811,7.811-7.811,20.474,0,28.284c7.81,7.81,20.474,7.811,28.285,0l77.37-77.37
                              c7.789-7.789,7.774-20.51,0-28.284l-77.37-77.37c-7.811-7.811-20.475-7.811-28.285,0c-7.81,7.811-7.811,20.474,0,28.284
                              L271.716,236H20c-11.046,0-20,8.954-20,20s8.954,20,20,20h251.716L228.487,319.228z"/>
                           <path d="M433.543,7.75C429.754,2.861,423.918,0,417.733,0H170c-11.046,0-20,8.954-20,20s8.954,20,20,20h237.719
                              C451.396,100.536,472,179.45,472,256c0,76.515-20.589,155.443-64.281,216H170c-11.046,0-20,8.954-20,20c0,11.046,8.954,20,20,20
                              h247.733c6.185,0,12.022-2.861,15.81-7.75C486.683,435.671,512,344.876,512,256C512,167.134,486.686,76.333,433.543,7.75z"/>
                        </g>
                     </symbol>
                  </svg>
                  <svg class="entrance">
                     <use xlink:href="#entrance"></use>
                  </svg>
               </a>
            </div>
         </div>   
      </header> --}}
      <!-- HEADER -->
      <section id="mistake" class="account">
         <div class="container">
            <div class="row account-block mistake-block">
               {{-- <button class="btn-active account__btn">
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
               </button> --}}
               <p class="mistake-prg">
                  OOOPS ... что-то пошло не так ....
               </p>
            </div>
            <div class="row mistake-img"
            style="display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 50px;
            margin-bottom: 50px;
            font-size: 10em;"
            >
               404
            </div>
            <div class="row">
               <button class="btn-active test-button mistake-btn">
                  <a href="/">На главную</a>
               </button>   
            </div>
         </div>
      </section>
      <footer>
         <div class="container">
            <div class="row footer__logo">
               <div class="logotip col-6">
                  <p>Система дистанционного обучения Росвуз</p>
               </div>
               <div class="col-6">
                  <a class="footer__link footer__link-active">
                     school@rosvuz.ru
                  </a>
               </div>
               
            </div>
            <div class="row">
               <a href="#" class="footer__links">
                  Политика конфидициальности
               </a>
               <a href="#" class="footer__links">
                  Правила пользования сайтом
               </a>
               <p class="footer__prg">
                  Все права защищены © 2021
               </p>
               <a class="footer__link">
                  school@rosvuz.ru
               </a>
            </div>
         </div>
      </footer>
      <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js"></script>
      <script src="{{mix('/js/app.js')}}"></script>
    </body>
</html>