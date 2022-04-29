<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Board;
use App\DirectMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DirectMessageRequest;

class RestDirectMessageController extends Controller
{
    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     //
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::debug('--------- RestDirectMessageController@show ---------');

         // メッセージボードとメッセージの取得
         $boardData = '';
         if($id){
         // メッセージが1件以上ある場合
         if(DirectMessage::where('board_id', $id)->count() !== 0){
         $boardData = Board::where('b.id', $id)
                 ->select([
                     'b.id',
                     'b.project_id',
                     'b.order_user_id',
                     'b.apply_user_id',
                     'd.id',
                     'd.board_id',
                     'd.message',
                     'd.send_user',
                     'd.receive_user',
                     'd.created_at'
                 ])
                 ->from('boards as b')
                 ->leftJoin('direct_messages as d', function($join){
                     $join->on('b.id', '=', 'd.board_id');
                 })
                 ->get();
         Log::debug('ダイレクトメッセージがあります');
         }else{
         // メッセージが1件もない場合
         $boardData = Board::find($id);
         Log::debug('ダイレクトメッセージはありません');
         }
        }
         return $boardData;
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DirectMessageRequest $request, $id)
    {
        Log::debug('--------- RestDirectMessageController@update ---------');

            //d_messageテーブルに保存
            if($id){
                
            $d_message = new DirectMessage;

            $d_message->board_id = $id;

            $d_message->fill($request->all())->save();

            Log::debug('privatemessageテーブルにダイレクトメッセージを保存しました');

            }
    }

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
