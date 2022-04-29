<!-- 案件登録・編集ページ  -->
 
@extends('layouts.index')

@section('title', '案件登録・編集')

@section('content')

<section class="p-container">
    <div  class="p-container__wrap">
        <h2>
            @if( $editflg )
                {{ __('New project registration') }}
            @else
                {{ __('Edit registered project') }}
            @endif
        </h2>
        <div class="p-container__panel">
            <div class="p-container__inner p-container__inner--large">
                <router-view :user-id='@json($user->id)' />
            </div>
        </div>
        @component('components.backlink')
        @endcomponent
    </div>
</section>

@endsection