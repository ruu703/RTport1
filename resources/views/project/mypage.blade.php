 <!-- マイページ  -->

 @extends('layouts.index')

 @section('title', 'マイページ')

 @section('content')

    <section class="p-container p-container--gray">
        <div  class="p-container__wrap">
            <div class="p-container__panel">
                <div class="p-container__inner p-container__inner--large u-margin-negative--5">
                    <div class="p-user p-user--profile">
                        <div class="p-user__img">
                            <img src="{{ asset( $user->profile_img ) }}" alt="プロフィール画像" class="p-user__avator p-user__avator--nomal">
                        </div>
                        <div class="p-user__name p-user__name--profile">
                            <span class="p-user__nickname">{{ $user->nickname }}</span> さん
                        </div>
                        <div class="p-user__intoduce">
                            {{ $user->introduction }}
                        </div>
                        <div class="p-container__btnwrap">
                            <a href="{{ route('profileform') }}" class="c-btn c-btn--black">
                                プロフィール編集
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <nav class="p-body-nav js-sub-nav-targt">
        <ul class="p-body-nav__ul">
            <li class="p-body-nav__li">
                <a href="{{ route('projectform') }}">
                    案件登録
                </a>
           </li>
            <li class="p-body-nav__li">
                <a href="#myproject">
                    登録済み案件
                </a>
            </li>
            <li class="p-body-nav__li">
                <a href="#appliedproject">
                    応募済み案件
                </a>
            </li>
            <li class="p-body-nav__li">
                <a href="#pub_message">
                    パブリックメッセージ
                </a>
            </li>
            <li class="p-body-nav__li">
                <a href="#dir_message">
                    ダイレクトメッセージ
                </a>
            </li>
            <li class="p-body-nav__li">
                <a href="#likes">
                    お気に入り
                </a>
            </li>
            <li class="p-body-nav__li">
                <a href="#top">
                    TOP
                </a>
            </li>
        </ul>
    </nav>

    <section class="p-container p-container--subnav p-container--gray" id="myproject">
        <div class="p-container__wrap">
            <h2>
                {{ __('List of registered projects') }}
            </h2>
            <div class="p-container__panel">
                <div class="p-container__inner p-container__inner--large u-margin-negative--5">
                    @if( !isset($myProjects[0]) )
                        登録案件はありません
                    @else
                    @foreach($myProjects as $project)
                    <a href="{{ route('project', $project->id) }}">
                        <div class="p-container__inner-list">
                            <div>
                                登録日 : {{ $project->created_at }}
                            </div>
                            <div>
                                案件名 : {{ Str::limit($project->title, 50) }}
                            </div>
                            <div>
                                状態 : @if( !$project->close_flg && !$project->delete_flg && empty($project->received_user_id) )
                                    募集中
                                @elseif( $project->received_user_id )
                                    受注者を決定しました
                                @elseif( $project->close_flg )
                                    終了しました
                                @elseif( $project->delete_flg )
                                    この案件は削除されました
                                @endif
                            </div>
                        </div>
                    </a>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="p-container p-container--subnav p-container--gray" id="appliedproject">
        <div  class="p-container__wrap">
            <h2>
            {{ __('List of submitted projects') }}
            </h2>
            <div class="p-container__panel">
                <div class="p-container__inner p-container__inner--large u-margin-negative--5">
                    @if( !isset($appliedProjects[0]) )
                    応募済み案件はありません
                    @else
                    @foreach($appliedProjects as $project)
                    <a href="{{ route('project', $project->project_id) }}">
                        <div class="p-container__inner-list">
                            <div>
                                応募日 : {{ $project->created_at }}
                            </div>
                            <div>
                                案件名 : {{ Str::limit($project->project->title, 50) }}
                            </div>
                            <div>
                                状態 : 
                                @if( $project->close_flg && $project->received_user_id == $user->id )
                                受注済しました！
                                @elseif( $project->close_flg )
                                受注しませんでした
                                @elseif( $project->delete_flg )
                                この案件は削除されました
                                @else
                                応募完了
                                @endif
                            </div>
                        </div>
                    </a>
                    @endforeach
                    @endif   
                </div>
            </div>
        </div>
    </section>

    <section class="p-container  p-container--subnav p-container--gray" id="pub_message">
        <div  class="p-container__wrap">
            <h2>
                {{ __('List of public messages') }}
            </h2>
            <div class="p-container__panel">
                <div class="p-container__inner p-container__inner--large u-margin-negative--5">
                    @if(!isset($publicMessage[0]))
                    パブリックメッセージはありません
                    @else
                    @foreach($publicMessage as $message)
                    <a href="{{ route('project', $message->project_id) }}#message">
                        <div class="p-container__inner-list">
                            <div>
                                案件名 : {{ Str::limit($message->title, 50) }}
                            </div>
                            <div>
                                最新メッセージ : {{ Str::limit($message->message, 50) }}
                            </div>
                        </div>
                    </a>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="p-container  p-container--subnav p-container--gray" id="dir_message">
        <div  class="p-container__wrap">
            <h2>
                {{ __('Direct message list') }}
            </h2>
            <div class="p-container__panel">
                <div class="p-container__inner p-container__inner--large u-margin-negative--5">
                    @if(!isset($directMessage[0]))
                    ダイレクトメッセージはありません
                    @else
                    @foreach($directMessage as $message)
                <a href="{{ route('message', $message->id) }}">
                    @if(empty($message->send_user == $user->id) && $message->delete_flg == 0)
                    <div class="p-container__circle">
                    </div>
                    @endif
                    <div class="p-container__inner-list">
                        <div>
                            案件名 : {{ Str::limit($message->title, 50) }}
                        </div>
                            @if($message->message_id)
                        <div>
                            最新メッセージ : {{ Str::limit($message->message, 50) }}
                        </div>
                        <div>
                            送信者 : {{ $message->nickname }}
                        </div>
                        <div>
                            送信日時 : {{ $message->created_at }}
                        </div>
                            @elseif($message->received_user_id == null && $message->order_user_id == $user->id)
                            <div class="c-notification">
                                まだメッセージがありません。応募者にメッセージを送ってみましょう！
                            </div>
                            @elseif($message->received_user_id != null && $message->order_user_id == $user->id)
                            <div class="c-notification">
                                まだメッセージがありません。受注者にメッセージを送ってみましょう！
                            </div>
                            @elseif($message->apply_user_id == $user->id)
                            <div class="c-notification">   
                                まだメッセージがありません。発注者にメッセージを送ってみましょう！
                            </div>
                            @endif
                    </div>
                </a>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</section>

    <section class="p-container  p-container--subnav p-container--gray" id="likes">
        <div  class="p-container__wrap">
            <h2>
                {{ __('Favorite list') }}
            </h2>
            <div class="p-container__panel">
                <div class="p-container__inner p-container__inner--large u-margin-negative--5">
                    @if(!isset($likes[0]))
                    お気に入りはありません
                    @else
                    @foreach($likes as $like)
                <a href="{{ route('project', $like->project_id) }}">
                    <div class="p-container__inner-list">
                        <div>
                            案件名 : {{ $like->title }}
                        </div>    
                    </div>
                </a>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</section>

@endsection