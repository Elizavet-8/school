<header>
    <div class="container">
        <div class="row">
            <div style="cursor:pointer" onclick="location.href='{{ url('/') }}'"
                 class="logotip col-md-5 col-sm-6 col-6">
                <p>Система дистанционного обучения Росвуз</p>
            </div>
            @role('admin|teacher')
            <a target="blank" style="max-height: 50px" href="{{ route('home.admin') }}" class="btn-active text-center col-1 col-lg-3 admin-btn mr-1">
                <p class="d-none d-lg-block mr-1">
                    <span>Панель администратора</span>
                </p>
                <i class="fas fa-user-cog admin-icon ml-1"></i>
            </a>
            @endrole
            @guest
                <a style="max-height: 50px" href="{{ route('login') }}" class="btn-active text-center col-lg-3 col-4">
                    <p>
                        Вход <span>в личный кабинет</span>
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
            @else
                <a style="max-height: 50px" class="btn-active text-center btn-exit col-lg-3 col-4" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                    <p style="margin-right: 15px">
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
                        <svg class="entrance">
                            <use xlink:href="#entrance"></use>
                         </svg>
                     </svg>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @endguest
        </div>
        
    </div>
</header>
