<?php

namespace App\Http\Controllers;

use App\Like;
use App\User;
use App\Board;
use App\Project;
use App\Category;
use App\DirectMessage;
use App\PublicMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ApplicationRequest;

class BaseController extends Controller
{
    // トップページ
    public function index()
    {
        Log::debug('--------- BaseController@index ---------');

        // 検索フォーム(components.searchform) 入力保持機能エラー対策のため空データを渡す
        $word = '';
        $category = '';
    
        // 新着案件（6件）データを表示
        $projects = '';
        $query = Project::with('category');

        $query->where([
            ['close_flg', '0'],
            ['delete_flg', '0']
        ])->orderBy('created_at', 'desc');

        $projects = $query->take(6)->get();
        
        return view('project.index', compact('projects', 'word', 'category'));
    }

    // 案件一覧・検索結果ページ
    public function search(Request $request)
    {
        Log::debug('--------- BaseController@search ---------');

        $word = $request->input('word');
        $category = $request->input('category');
        Log::debug('$word-> '.$word);
        Log::debug('$category-> '.$category);

        // 案件データ一覧セット用
        $projects = '';
        $query = Project::with('category');

         // フリーワード、カテゴリー共に入力のない場合
         if(empty($word) && !isset($category)){
            Log::debug('フォーム入力はありません');

            $query->where([
            ['close_flg', '0'],
            ['delete_flg', '0']
        ])->orderBy('created_at', 'desc');
            
            $projects = $query->paginate(12);

        // フリーワード入力有り、カテゴリー選択のない場合
        }else if($word && !isset($category)){
        Log::debug('フリーワード入力あり');

        $query->where([
        ['title', 'like', '%'.$word.'%'],
        ['close_flg', '0'],
        ['delete_flg', '0']
        ])->orderBy('created_at', 'desc');

        $projects = $query->paginate(12);
        
        // フリーワード入力無し、カテゴリー選択のある場合
        }else if(empty($word) && isset($category)){
        Log::debug('カテゴリー選択あり');

        $query->where([
        ['close_flg', '0'],
        ['delete_flg', '0'],
        ['category_id', $category]
        ])->orderBy('created_at', 'desc');

        $projects = $query->paginate(12);

        // フリーワード入力有り、カテゴリー選択のある場合
        }else{
        Log::debug('フリーワード入力、カテゴリー選択あり');

        $query->where([
        ['close_flg', '0'],
        ['delete_flg', '0'],
        ['title', 'LIKE', '%'.$word.'%'],
        ['category_id', $category]
        ])->orderBy('created_at', 'desc');

        $projects = $query->paginate(12);

            }
        return view('project.search', compact('projects', 'word', 'category'));
    }

     // 案件詳細ページ
    public function project($id)
    {
        Log::debug('--------- BaseController@project ---------');

        // 案件詳細ページ　

        if(!ctype_digit($id)){
            Log::debug('エラー : 不正な値が入力されました。');
            return redirect('/')->with('flash_message', __('Invalid operation was performed.'));
        }

        Log::debug('idは'.$id.'です。');

        // 案件と案件の発注者情報
        $projects = Project::select([
            'p.id',
            'p.title',
            'p.category_id',
            'p.fee_low',
            'p.fee_high',
            'p.detail',
            'p.order_user_id',
            'p.received_user_id',
            'p.close_flg',
            'p.delete_flg',
            'u.nickname',
            'u.profile_img'
        ])
        ->where('p.id', $id)
        ->from('projects as p')
        ->join('users as u', function($join){
            $join->on('p.order_user_id', '=', 'u.id');
        })
        ->get();


        // 配列から取り出す
        $project = '';
        foreach($projects as $val){
            $project = $val;
        }

        // 案件種別検索
        $categories = Category::whereHas('projects', function($query) use($project){
            $query->where('category_id', $project->category_id);
        })->get();

        // 配列から取り出す
        $category = '';
        foreach($categories as $val){
            $category = $val;
        }

        $applied = '';
        if(Auth::id()){

        // 案件に応募済みか判定　
        // 応募済みであれば応募ボタンを非表示にする
        $applied = Board::with('user')->where([
            ['apply_user_id', Auth::id()],
            ['project_id', $id]
            ])->count();
        }

        Log::debug('$applied-> '.$applied);

        $board = '';
        $board = Board::where('project_id', $id)->count();

        return view('project.project', compact('project', 'category', 'applied', 'board'));
    }

    // プロフィールページ
    public function profile($id)
    {
        Log::debug('--------- BaseController@profile ---------');

        if(!ctype_digit($id)){
            return redirect('/')->with('flash_message', __('Invalid operation was performed.'));
        }

        // プロフィール情報取得
        $profile = User::find($id);

        // プロフィール表示者の登録した案件データを取得
        $query = Project::with('category');

        $query->where([
            ['order_user_id', $profile->id],
            ['close_flg', '0'],
            ['delete_flg', '0']
        ])->orderBy('created_at', 'desc');

        $projects = $query->get();

        return view('project.profile', compact('profile', 'projects'));
    }

    // マイページ
    public function mypage()
    {
        Log::debug('--------- BaseController@mypage ---------');

        // 登録した案件データを取得
        $myProjects = Project::where('order_user_id', Auth::id())->orderBy('created_at', 'desc')->get();

        // 応募した案件データを取得
        $appliedProjects = Board::with('project')->where('apply_user_id', Auth::id())->get();

        // ダイレクトメッセージid取得(boardテーブルid)
        $boardId = Board::where('order_user_id', Auth::id())
                        ->orWhere('apply_user_id', Auth::id())
                        ->select('id')
                        ->get();
                        // Log::debug('$boardId : '. $boardId);

        // 最新ダイレクトメッセージ取得
        $directMessage = [];
        if($boardId){
            foreach($boardId as $id){
                $directMessage[] = DB::table('boards')
                                ->select(
                                    'boards.id',
                                    'boards.order_user_id',
                                    'boards.apply_user_id',
                                    'p.title',
                                    'p.received_user_id',
                                    'p.close_flg',
                                    'p.delete_flg',
                                    'm.id as message_id',
                                    'm.message',
                                    'm.send_user',
                                    'm.receive_user',
                                    'm.created_at',
                                    'u.nickname'
                                )
                                ->where('boards.id', $id->id,)
                                ->Leftjoin('projects as p', 'p.id', '=', 'boards.project_id')
                                ->Leftjoin('direct_messages as m', 'm.board_id', '=', 'boards.id')
                                ->LeftjoinSub(DB::table('users')->select('nickname', 'id', 'delete_flg')->where('delete_flg', 0),
                                    'u', function($join){
                                        $join->on('m.send_user', '=', 'u.id');
                                    })
                                ->orderBy('m.created_at', 'desc')
                                ->latest('m.created_at')
                                ->first();
            }
        }

        // メッセージ投稿日時(created_at)の新しい順に並び替える
        $directMessage = collect($directMessage);

        $directMessage= $directMessage->sortByDesc('created_at');

        Log::debug('$directMessage : '.$directMessage);
        
        // 自分の投稿したパッブリックメッセージの属する案件(porojectテーブルのidカラム)データ取得
        $projectsId = DB::table('public_messages')
                    ->select('project_id', DB::raw('MAX(created_at) as latest_created_at'))
                    ->where('public_messages.user_id', Auth::id())
                    ->groupBy('project_id',)
                    ->orderBy('latest_created_at', 'desc')
                    ->get();

        // $projectsIdを元に、自分が投稿したメッセージの属する案件情報と最新メッセージを取得
        $publicMessage = [];
        foreach($projectsId as $id){
        // Log::debug('$id : '.$id->project_id);
        $publicMessage[] = DB::table('projects')
                        ->from('projects as p')
                        ->where('p.id', $id->project_id)
                        ->rightJoin('public_messages as m', 'p.id', '=', 'm.project_id')
                        ->where('m.project_id', $id->project_id)
                        ->latest('m.created_at')
                        ->first();
                }
                // Log::debug(print_r($privateMessage, true));

        $likes = Like::where('user_id', Auth::id())
                ->select([
                        'likes.user_id',
                        'likes.project_id',
                        'likes.created_at',
                        'p.title'
                        ])
                ->join('projects as p', 'p.id', '=', 'likes.project_id')
                ->orderBy('likes.created_at', 'desc')
                ->get();
                // Log::debug('$likes : '.$likes);

        return view('project.mypage', compact('myProjects', 'appliedProjects', 'publicMessage', 'directMessage', 'likes'));
    }

    // ダイレクトメッセージページ
    public function message($id = 0)
    {
        Log::debug('--------- BaseController@message ---------');

        if(!ctype_digit($id)){
            Log::debug('エラー : 不正な値が入力されました。');
            return redirect('/')->with('flash_message', __('Invalid operation was performed.'));
        }

        $board = Board::find($id);

        // メッセージ送信相手のユーザーIDを取得
        if($board){
            $partnerUserId = '';
            $myUserId = '';
            if(Auth::id() != $board->order_user_id){
                $partnerUserId = $board->order_user_id;
                $myUserId = $board->apply_user_id;
            }elseif(Auth::id() != $board->apply_user_id){
                $partnerUserId = $board->apply_user_id;
                $myUserId = $board->order_user_id;
            }
        }else{
            Log::debug('エラー : 不正なアクセスです。');
            return redirect('/')->with('flash_message', __('Invalid operation was performed.'));
        }

        // 案件投稿者・案件応募者のどちらでもないアクセスはトップページへリダイレクト
        if($myUserId  !== Auth::id()){
            Log::debug('エラー : 不正なアクセスです。');
            return redirect('/')->with('flash_message', __('Invalid operation was performed.'));
        }

        //　メッセージ送信相手のユーザー情報を取得
        $partnerUserInfo = '';
        if(isset($partnerUserId)){
            $partnerUserInfo = User::find($partnerUserId);
        }

        if(empty($partnerUserInfo)){
            Log::debug('エラー : 取引相手のユーザー情報が取得できませんでした。');
            return redirect('/')->with('flash_message', __('Invalid operation was performed.'));
        }

        // 案件と案件の発注者情報を取得
        $projects = Project::select([
            'p.id',
            'p.title',
            'p.category_id',
            'p.fee_low',
            'p.fee_high',
            'p.detail',
            'p.order_user_id',
            'p.received_user_id',
            'p.close_flg',
            'p.delete_flg',
            'u.nickname',
            'u.profile_img'
        ])
        ->where('p.id', $board->project_id)
        ->from('projects as p')
        ->join('users as u', function($join){
            $join->on('p.order_user_id', '=', 'u.id');
        })
        ->get();

        // 配列から取り出す
        $project = '';
        foreach($projects as $val){
            $project = $val;
        }

        // 案件種別検索
        $categories = Category::whereHas('projects', function($query) use($project){
            $query->where('category_id', $project->category_id);
        })->get();

        // 配列から取り出す
        $category = '';
        foreach($categories as $val){
            $category = $val;
        }

        return view('project.message', compact('project', 'category', 'partnerUserInfo'));
    }

    // 応募案件確認画面
    public function projectVerification($id){

        Log::debug('--------- BaseController@projectVerification ---------');

        if(!ctype_digit($id)){
            Log::debug('エラー : 不正な値が入力されました。');
            return redirect('/')->with('flash_message', __('Invalid operation was performed.'));
        }

        Log::debug('idは'.$id.'です。');

        // 案件と案件の発注者情報
        $projects = Project::select([
            'p.id',
            'p.title',
            'p.category_id',
            'p.fee_low',
            'p.fee_high',
            'p.detail',
            'p.order_user_id',
            'p.close_flg',
            'p.delete_flg',
            'u.nickname',
            'u.profile_img'
        ])
        ->where('p.id', $id)
        ->from('projects as p')
        ->join('users as u', function($join){
            $join->on('p.order_user_id', '=', 'u.id');
        })
        ->get();

        // 配列から取り出す
        $project = '';
        foreach($projects as $val){
            $project = $val;
        }

        // 案件種別検索
        $categories = Category::whereHas('projects', function($query) use($project){
            $query->where('category_id', $project->category_id);
        })->get();

        // 配列から取り出す
        $category = '';
        foreach($categories as $val){
            $category = $val;
        }

        return view('project.projectVerification', compact('project', 'category'));
    }

    // 案件応募時にboardテーブルにレコードを作成してダイレクトメッセージページに遷移
    public function postApplication(ApplicationRequest $request){

        Log::debug('--------- BaseController@postApplication ---------');

        // Log::debug(print_r($request->all(), true));

            $board = new Board;
            $board->apply_user_id = Auth::id();
            $board->fill($request->all())->save();

            $board = Board::where('project_id', $request->project_id)->orderBy('created_at', 'desc')->first();
            Log::debug('$board->id '.$board->id);

            return redirect()->route('message', $board->id,
            )->with(['flash_message' => __('案件に応募しました！')]);

    }

    // 利用規約ページ
    public function term(){
        return view('project.userterms');
    }

    // プライバシーポリシーページ
    public function privacy(){
        return view('project.privacypolicy');
    }
    
}
