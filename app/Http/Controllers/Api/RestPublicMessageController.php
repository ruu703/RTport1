<?php

namespace App\Http\Controllers\Api;

use App\Project;
use App\PublicMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\PublicMessageRequest;

class RestPublicMessageController extends Controller
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // パブリックメッセージをDBに保存
    public function store(PublicMessageRequest $request)
    {
        Log::debug('--------- RestPublicMessageController@store ---------');

        // Log::debug('$request'.$request);

        $publicMessage = new PublicMessage;
        
        // privatemessageテーブルに保存
        $publicMessage->fill($request->all())->save();

        Log::debug('publicmessageテーブルにパブリックメッセージを保存しました');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 案件情報
        $projects = Project::select([
            'id',
            'order_user_id',
            'received_user_id',
            'close_flg',
            'delete_flg',
        ])
        ->where('id', $id)
        ->get();


        // 配列から取り出す
        $project = '';
        foreach($projects as $val){
            $project = $val;
        }

        // パブリックメッセージ
        // メッセージと送信者の情報を取得
        $message = PublicMessage::with('user')->where('project_id', $id)->get();

        return compact('project', 'message');
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
