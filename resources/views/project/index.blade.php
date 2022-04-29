 <!-- topページ  -->

@extends('layouts.index')

@section('content')

<section class="p-container p-container--gray">
    <div  class="p-container__top">
        <div>
            <h1>
                <span class="u-indention">すぐに 探せる、</span>
                <span class="u-indention">見つかる</span></br>
                <span class="u-indention">エンジニア案件</span>
                <span class="u-indention">マッチングサービス</span>
            </h1>
            <div class="p-container__button">
                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="c-btn p-container__button--red">無料会員登録</a>
                @endif
            </div>
            <p class="p-container__info">
                面倒な入力はナシ！</br>
                カンタン登録30秒。
            </p>
        </div>
    </div>
</section>

<section class="p-container" id="search">
    <div class="p-container__wrap">
        <h2 class="c-title">
            {{ __('Search project') }}
        </h2>

        <!-- 案件検索フォーム -->
        @component('components.searchform')
            @slot('word')
                {{ $word }}
            @endslot
                        
            @slot('category')
                {{ $category }}
            @endslot
        @endcomponent

    </div>
</section>

<section class="p-container p-container--gray">
    <div  class="p-container__wrap">
        <h2 class="c-title">
            {{ __('New projects') }}
        </h2>
        <router-view :projects='@json($projects)'></router-view>
        <div class="p-btnwrap p-btnwrap--m">
            <a href="{{ route('search') }}#search" class="c-btn c-btn--black p-btnwrap__right">
            {{ __('Project List') }}　&gt;
            </a> 
        </div>
    </div>
</section>

@endsection