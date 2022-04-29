 <!-- 検索ページ  -->

 @extends('layouts.index')

 @section('title', '検索結果')

 @section('content')


<section class="p-container">
    <div  class="p-container__wrap">
        <h2 class="c-title">
            {{ __('Narrow down the project') }}
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
        <div class="p-container__body">
            <h2 id="search">
                {{ __('Project List') }}
            </h2>
            <span class="u-indention">
                {{ $word }}
                @if(!empty($category) && $category == 1)
                単発案件 
                @elseif(!empty($category) && $category == 2)
                レベニューシェア案件 
                @endif
                @if(!empty($word) || !empty($category))
                の検索結果
                @endif
                {{ $projects->total() }}件
            </span>
        </div>

        <!-- <searchproject-component :projects='@json($projects)'></searchproject-component> -->
        <router-view :projects='@json($projects)'></router-view>

        <div class="c-pagenation">
            {{ $projects->appends(['word' => $word, 'category' => $category])->fragment('search')->links('vendor.pagination.match') }}
        </div>
        <div class="p-btnwrap p-btnwrap--m">
            <a href="{{ route('index') }}" class="c-btn c-btn--black p-btnwrap__right">
                {{ __('Back') }}　&gt;
            </a> 
        </div>
    </div>
</section>

@endsection