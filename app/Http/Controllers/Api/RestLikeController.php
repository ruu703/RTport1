<?php

namespace App\Http\Controllers\Api;

use App\Like;
use Illuminate\Http\Request;
use App\Http\Requests\LikeRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RestLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // お気に入り表示
    public function index(Request $request)
    {
        Log::debug('--------- RestLikeController@index ---------');

        Log::debug('$projectId : '.$request->projectId);
        Log::debug('$userId : '.$request->userId);
 
        $like = '';
        if($request->has(['projectId', 'userId'])){
        $like = Like::where([
            ['project_id', $request->projectId],
            ['user_id', $request->userId]
            ])->get();

        Log::debug('Like : '.$like);
        }
        return $like;
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
    // お気に入りに登録
    public function store(LikeRequest $request)
    {
            $like = new Like;
            $like->project_id = $request->project_id;
            $like->user_id = $request->user_id;
            $like->fill($request->all())->save();

            Log::debug('likesテーブルにレコードを作成しました。');
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     //
    // }

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // お気に入りを解除
    public function destroy($id)
    {
        Log::debug('--------- RestLikeController@destroy ---------');

        if($id && Like::find($id)->exists()){
            Like::find($id)->delete();
        }
    }
}
