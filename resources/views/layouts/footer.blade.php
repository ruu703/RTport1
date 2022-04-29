
<div class="p-footer">
    <nav>
        <ul class="p-footer__menu">
            <li class="p-footer__item">
                <a href="{{ route('term') }}" class="p-footer__link">利用規約</a>
            </li>
            <li class="p-footer__item">
                |
            </li>
            <li class="p-footer__item">
                <a href="{{ route('privacy') }}" class="p-footer__link">プライバシーポリシー</a>
            </li>
            <li class="p-footer__item">
                |
            </li>
            <li class="p-footer__item">
                <a href="{{ route('search') }}#search" class="p-footer__link">案件一覧</a>
            </li>
            @guest
            <li class="p-footer__item">
                |
            </li>
            <li class="p-footer__item">
                <a href="{{ route('login') }}#search" class="p-footer__link">ログイン</a>
            </li>
            <li class="p-footer__item">
                |
            </li>
            <li class="p-footer__item">
                <a href="{{ route('register') }}#search" class="p-footer__link">新規登録</a>
            </li>
            @endguest
            @auth
            <li class="p-footer__item">
                |
            </li>
            <li class="p-footer__item">
                <a href="{{ route('projectform') }}#search" class="p-footer__link">案件登録</a>
            </li>
            <li class="p-footer__item">
                |
            </li>
            <li class="p-footer__item">
                <a href="{{ route('logout') }}" class="p-footer__link"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
            @endauth
        </ul>
    </nav>
    <span>©︎2022 match, Inc.</span>
</div>