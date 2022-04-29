 <!-- 応募案件の確認ページ  -->

 @extends('layouts.index')

 @section('title', '応募案件の確認')

 @section('content')

<section class="p-container p-container--gray">
    <div  class="p-container__wrap">
        <h2>
            {{ __('Confirmation of application') }}
        </h2>
        <div class="p-container__panel">
            <span class="p-container__tag p-container__tag--large">
                {{ $category->category_name}}
            </span>
            <div class="p-container__inner p-container__inner--project">
                <h2>
                    {{ $project->title}}
                </h2>
                <div class="p-container__type">
                    @if( $project->category_id === 1 )
                        報酬
                    @else
                        収益分配率
                    @endif
                </div>
                <span class="p-container__reward p-container__reward--large">
                    {{ $project->fee_low }}〜{{ $project->fee_high }}
                    @if( $project->category_id === 1)
                        円
                    @else
                        %
                    @endif
                </span>
                <p class="p-container__article">
                    {{ $project->detail }}
                </p>
                            
                <div class="p-container__btnwrap">
                    @auth
                        {{Form::open(['method' => 'post', 'route' => ['application', 
                        'project_id' => $project->id, 'order_user_id' => $project->order_user_id]])}}
                            
                        {{Form::submit('応募を確定する', ['class' => 'c-btn p-container__submit p-container__submit--red'])}}
                
                        {{Form::close()}}
                    @endauth
                </div>
                <hr class="p-container__hr">
                    <span>
                        この案件の発注者
                    </span>
                    <div class="p-user">
                        <div class="p-user__img">
                            <a href="{{ route('profile', $project->order_user_id) }}">
                                <img src="{{ asset( $project->profile_img ) }}" alt="プロフィール画像" class="p-user__avator p-user__avator--nomal">
                            </a>
                        </div>
                        <div class="p-user__name p-user__name--large">
                            <a href="{{ route('profile', $project->order_user_id) }}">
                                <span class="p-user__nickname">{{ $project->nickname }}</span> さん
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @component('components.backlink')
            @endcomponent

        </div>
    </div>
</section>


@endsection