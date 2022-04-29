            <div class="p-header"  id="top">
            @include('layouts.flashmessage')
                <a href="{{ route('index') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="ロゴ" class="p-header__logo">
                </a>
                
                <div class="p-menu-trigger js-toggle-sp-menu">
                    <span class="p-menu-trigger__span"></span>
                    <span class="p-menu-trigger__span"></span>
                    <span class="p-menu-trigger__span"></span>
                </div>
                <nav class="p-header__nav js-toggle-sp-menu-target" id="nav">
                    <ul class="c-nav">
                        <li class="c-nav__list">
                            <a href="{{ route('search') }}#search" class="c-nav__link">案件一覧</a>
                        </li>
                        @if (Route::has('login'))
                            @auth
                            
                                <li class="c-nav__list">
                                    <a href="{{ route('projectform') }}" class="c-nav__button c-nav__button--red">案件登録</a>
                                </li>
                                    @if(Route::is('mypage*'))
                                    <li class="c-nav__list c-nav__list--sub">
                                        <a href="#myproject" class="c-nav__link">
                                            登録済み案件
                                        </a>
                                    </li>
                                    <li class="c-nav__list c-nav__list--sub">
                                        <a href="#appliedproject" class="c-nav__link">
                                            応募済み案件
                                        </a>
                                    </li>
                                    <li class="c-nav__list c-nav__list--sub">
                                        <a href="#pub_message" class="c-nav__link">
                                            パブリックメッセージ
                                        </a>
                                    </li>
                                    <li class="c-nav__list c-nav__list--sub">
                                        <a href="#dir_message" class="c-nav__link">
                                            ダイレクトメッセージ
                                        </a>
                                    </li>
                                    <li class="c-nav__list c-nav__list--sub">
                                        <a href="#likes" class="c-nav__link">
                                            お気に入り
                                        </a>
                                    </li>
                                    @else
                                    <li class="c-nav__list">
                                    <a href="{{ url('/mypage') }}"  class="c-nav__link">マイページ</a>
                                    </li>
                                    @endif 
                                    <li class="c-nav__list">
                                    <a href="{{ route('logout') }}" class="c-nav__link" 
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li> 
                                @else
                                <li class="c-nav__list">
                                    <a href="{{ route('login') }}"  class="c-nav__link">ログイン</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="c-nav__list">
                                        <a href="{{ route('register') }}"  class=" c-nav__button c-nav__button--red">新規登録</a>
                                    </li>
                                @endif
                            @endauth
                        @endif
                    </ul>
                </nav>
            </div>
