<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Storage;

class RestProfileController extends Controller
{
    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    public function index()
    {
        // Log::debug('--------- RestprofileController@index ---------'); 
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // プロフィール編集
    public function store(ProfileRequest $request)
    {
        Log::debug('--------- RestprofileController@store ---------'); 

        Log::debug($request->file);

        Log::debug(Auth::id());

        $user = User::find($request->id);

        // フォームにファイルがある場合
        if($request->hasFile('file')){

            // ファイル名取得
            $filename = $request->file->getClientOriginalName();
            
            // 画像を保存
            $path = $request->file->storeAs('public/profimg', uniqid().$filename);

            // 画像パスをデータベースに保存
            $user->profile_img = $path;

        // AWSへ保存する場合
        // s3への保存準備
        // $disk = Storage::disk('s3');

        // $profImg = $request->file;

        // // 画像をs3に保存してパスを取得
        // $path = $disk->putFile('profImg', $profImg,'public');

        // // ファイルパスをセット
        // $user->profile_img = $path;
        }

        // ニックネームが空の場合は　匿名ユーザー　をセット
        if(empty($request->nickname)){
            $user->nickname = '匿名ユーザー';
        }else{
            $user->nickname = $request->nickname;
        }
        
        $user->email = $request->email;
        $user->introduction = $request->introduction;

        // DBに保存したらメッセージを表示する
        if($user->save()){
            Log::debug('profileテーブルを上書きしました');

            return ['success' => '登録しました!'];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::debug('--------- RestprofileController@show ---------'); 
        
        // return Auth::user();
        return User::find($id);
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     //
    // }
}
