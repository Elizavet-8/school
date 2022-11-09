<div style="margin-left:0; margin-right:0" class="row account-block">
    <button onclick="location.href='{{ route('theme.menu', $theme['id']) }}'" class="btn-active account__btn">
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
        <p>Вернуться в тему</p>
    </button>
    <div class="account-elem">
        <svg style="
                                width: 26px;
                                height: 26px;
                                margin-right: 10px;
                                fill: #fabe4b;" height="512pt" viewBox="0 0 512 512" width="512pt"
             xmlns="http://www.w3.org/2000/svg">
            <path
                d="m369.164062 174.769531c7.8125 7.8125 7.8125 20.476563 0 28.285157l-134.171874 134.175781c-7.8125 7.808593-20.472657 7.808593-28.285157 0l-63.871093-63.875c-7.8125-7.808594-7.8125-20.472657 0-28.28125 7.808593-7.8125 20.472656-7.8125 28.28125 0l49.730468 49.730469 120.03125-120.035157c7.8125-7.808593 20.476563-7.808593 28.285156 0zm142.835938 81.230469c0 141.503906-114.515625 256-256 256-141.503906 0-256-114.515625-256-256 0-141.503906 114.515625-256 256-256 141.503906 0 256 114.515625 256 256zm-40 0c0-119.394531-96.621094-216-216-216-119.394531 0-216 96.621094-216 216 0 119.394531 96.621094 216 216 216 119.394531 0 216-96.621094 216-216zm0 0"/>
        </svg>
        <p class="exp-prg">
            {{ $theme->chapter->themes->count() }} тем
            <br>({{ $theme->chapter->course->completeCount(Auth::user()->id) }} выполнено)
        </p>
        @if ($theme->chapter->course->hours)
            <svg style="
                                width: 26px;
                                height: 26px;
                                margin-right: 10px;
                                fill: #fabe4b;" height="512pt" viewBox="0 0 512 512" width="512pt"
                 xmlns="http://www.w3.org/2000/svg">
                <path
                    d="m369.164062 174.769531c7.8125 7.8125 7.8125 20.476563 0 28.285157l-134.171874 134.175781c-7.8125 7.808593-20.472657 7.808593-28.285157 0l-63.871093-63.875c-7.8125-7.808594-7.8125-20.472657 0-28.28125 7.808593-7.8125 20.472656-7.8125 28.28125 0l49.730468 49.730469 120.03125-120.035157c7.8125-7.808593 20.476563-7.808593 28.285156 0zm142.835938 81.230469c0 141.503906-114.515625 256-256 256-141.503906 0-256-114.515625-256-256 0-141.503906 114.515625-256 256-256 141.503906 0 256 114.515625 256 256zm-40 0c0-119.394531-96.621094-216-216-216-119.394531 0-216 96.621094-216 216 0 119.394531 96.621094 216 216 216 119.394531 0 216-96.621094 216-216zm0 0"/>
            </svg>
            <p class="exp-prg">
                @if($theme->chapter->course->hours % 10  == 1)
                    {{ $theme->chapter->course->hours }} час <br>обучения
                @elseif($theme->chapter->course->hours % 10  == 2 || $theme->chapter->course->hours % 10  == 3  || $theme->chapter->course->hours % 10  == 4)
                    {{ $theme->chapter->course->hours }} часa <br>обучения
                @else
                    {{ $theme->chapter->course->hours }} часов <br>обучения
                @endif
            </p>
        @endif
        <div class="courses__expert expert row">
            <div class="expert__txt">
                <div>
                    учитель
                </div>
                <p>
                    {{ $theme->chapter->course->user->name }}
                </p>
            </div>
            <img
                src="{{ $theme->chapter->course->user->img_url ? $theme->chapter->course->user->img_url : ('/images/default-avatar.jpg') }}"
                alt="person">
        </div>
    </div>
</div>
