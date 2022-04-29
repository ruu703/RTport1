<!-- 案件登録・編集ページ  -->
 
@extends('layouts.index')

@section('title', 'プロフィール編集')

@section('content')

<section class="p-container">
    <div  class="p-container__wrap">
        <h2>
            {{ __('Edit profile') }}
        </h2>
        <div class="p-container__panel">
            <div class="p-container__inner p-container__inner--large">
                <router-view :user-obj='@json($user)' />
            </div>
        </div>

        @component('components.backlink')
        @endcomponent

    </div>
</section>

@endsection