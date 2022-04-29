<!-- ダイレクトメッセージページ  -->
 
@extends('layouts.index')

@section('title', 'ダイレクトメッセージ')

@section('content')

<section class="p-container">
    <div  class="p-container__wrap">
        <h2>
        {{ __('Direct Message') }}
        </h2>
        <div class="p-container__panel">
            <a href="{{ route('profile', $partnerUserInfo->id) }}">
                <div class="p-container__inner p-container__inner--large">
                    <div>
                        @if($partnerUserInfo->id == $project->order_user_id)
                        <span class="c-badge">発注者</span>
                        @elseif($partnerUserInfo->id == $project->received_user_id)
                        <span class="c-badge">受注者</span>
                        @endif
                    </div>
                    <div class="p-user p-user--profile">
                        <div class="p-user__img">
                            <img src="{{ asset( $partnerUserInfo->profile_img ) }}" alt="プロフィール画像" class="p-user__avator p-user__avator--nomal">
                        </div>
                        <div class="p-user__name p-user__name--profile">
                            <span class="p-user__nickname">{{ $partnerUserInfo->nickname }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>

<section class="p-container p-container--gray">
    <div  class="p-container__wrap">
        <h2>
            {{ __('Project of this message') }}
        </h2>
        <div class="p-container__panel p-container__panel--scale">
            <a href="{{ route('project', $project->id) }}">
                <span class="p-container__tag">
                    {{ $category->category_name}}
                </span>
                <div class="p-container__inner p-container__inner--middle">
                    <h3>
                        {{ $project->title}}
                    </h3>
                    <div>
                        @if( $project->category_id === 1 )
                            報酬
                        @else
                            収益分配率
                        @endif
                    </div>
                    <span class="p-container__reward">
                        {{ number_format($project->fee_low) }}〜{{ number_format($project->fee_high) }}
                        @if( $project->category_id === 1)
                            円
                        @else
                            %
                        @endif
                    </span>
                    <p>
                        {{ $project->detail}}
                    </p>
                </div>
            </a>
        </div>
    </div>
</section>
            

<section class="p-container">
    <div  class="p-container__wrap">
        <h2>
            {{ __('Message') }}
        </h2>

        <router-view :partner-user-info='@json($partnerUserInfo)' :my-user-info='@json($user)' />

        @component('components.backlink')
        @endcomponent
     </div>
</section>

@endsection