 <!-- プロフィールページ  -->

 @extends('layouts.index')

 @section('title', 'プロフィール')

 @section('content')
 
<section class="p-container">
    <div  class="p-container__wrap">
        <h2>
            {{ $profile->nickname }}
            {{ __('Profile') }}　
        </h2>
        <div class="p-container__panel">
            <div class="p-container__inner p-container__inner--large">
                <div class="p-user p-user--profile">
                    <div class="p-user__img">
                        <img src="{{ asset( $profile->profile_img )  }}" alt="プロフィール画像" class="p-user__avator p-user__avator--nomal">
                    </div>
                    <div class="p-user__name p-user__name--profile">
                        <span class="p-user__nickname">{{ $profile->nickname }}</span>
                    </div>
                    <div class="p-user__intoduce">
                        {{ $profile->introduction}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

 <section class="p-container p-container--gray">
    <div  class="p-container__wrap">
        <h2>
            {{ $profile->nickname }}
            {{ __('Project') }}
        </h2>
                    
        <router-view :projects='@json($projects)'></router-view>
                    
        @component('components.backlink')
        @endcomponent
    </div>
</section>
@endsection