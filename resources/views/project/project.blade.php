 <!-- 案件詳細ページ  -->

 @extends('layouts.index')

 @section('title', $project->title)

 @section('content')

<section class="p-container p-container--gray">
                @auth
                    @if($user->id == $project->order_user_id)
                    <!-- 応募者一覧 -->
                    <div  class="p-container__wrap">
                        <h2>
                            {{ __('List of applicants') }}
                        </h2>
                        <div class="p-container__panel">
                            <div class="p-container__inner p-container__inner--large">
                                <router-view name="AppliedUser"></router-view>   
                            </div>
                        </div>
                    </div>
                    @endif
                @endauth

                <div  class="p-container__wrap">
                    @auth
                        <!-- 編集ボタン -->
                        @if($user->id == $project->order_user_id && $project->close_flg == 0 && $project->delete_flg == 0 && $board == null)
                            <div class="p-btnwrap p-btnwrap--s">
                                <a href="{{ route('projectform', ['any' => $project->id]) }}" class="c-btn c-btn--black p-btnwrap__right">編集</a>
                            </div>
                        @endif
                    @endauth

                    <div class="p-container__panel">
                        <span class="p-container__tag p-container__tag--large">
                            {{ $category->category_name}}
                        </span>

                        <!-- お気に入り追加ボタン -->
                        @auth
                            @if($user->id != $project->order_user_id)
                            <router-view name="Like" :user-id='@json($user->id)'></router-view>
                            @endif
                        @endauth
                        

                        <div class="p-container__inner p-container__inner--project">
                            <h2>
                                {{ $project->title }}
                            </h2>
                            <div class="p-container__type">
                                @if( $project->category_id === 1 )
                                報酬
                                @else
                                収益分配率
                                @endif
                            </div>
                            <span class="p-container__reward p-container__reward--large">
                                {{ number_format($project->fee_low) }}〜{{ number_format($project->fee_high) }}
                                @if( $project->category_id === 1)
                                円
                                @else
                                %
                                @endif
                            </span>
                            <p class="p-container__article">
                                {{ $project->detail }}
                            </p>
                            
                            <div class="p-container__btnwrap p-container__btnwrap--right">
                                <a href="http://twitter.com/share?url={{ route('project', $project->id) }}&text=match-エンジニア案件マッチングサービス {{ $project->title }}" target="_blank"
                                class="p-container__twitter">
                                <i class="fab fa-twitter p-container__i"></i>
                                <span>
                                シェア
                                </span>
                                </a>
                            </div>
        
                            <div class="p-container__btnwrap">
                                @auth
                                    @if( $user->id !== $project->order_user_id && $applied == 0 )
                                    <a href="{{ route('verification', $project->id) }}" class="c-btn p-container__submit p-container__submit--red">
                                        応募する
                                    </a>
                                    @elseif( $user->id !== $project->order_user_id && $applied !== 0 )
                                        応募済みの案件です
                                    @endif
                                @endauth
                                @guest
                                <a href="{{ route('register') }}" class="c-btn p-container__submit p-container__submit--red">
                                    <span class="u-indention">会員登録して</span><span class="u-indention">応募する</span>
                                </a>
                                @endguest
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
                                        <span class="p-user__nickname">{{ $project->nickname }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- メッセージ -->
                <div  class="p-container__wrap" id="message">
            
                    <router-view :user='@json($user)'/>
                    
                    @component('components.backlink')
                    @endcomponent
                </div>
            </section>


@endsection