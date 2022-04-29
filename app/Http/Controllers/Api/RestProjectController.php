<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Board;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProjectRequest;

class RestProjectController extends Controller
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
    // 新規案件の登録
    public function store(ProjectRequest $request)
    {
        Log::debug('--------- RestProjectCintroller@store ---------');

        $project = new Project;
        $project->fill($request->all())->save();

        Log::debug('projectテーブルに新規案件を保存しました');

        return ['success' => '案件を投稿しました！'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // 登録済み案件の編集フォームを表示
    public function show($id)
    {
        Log::debug('--------- RestProjectController@show ---------'); 
        
        if($id){
            return Project::find($id);
        }
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
    // 案件の上書き登録
    public function update(ProjectRequest $request, $id)
    {
        Log::debug('--------- RestProjectController@update ---------');

        if($id){

        $project = Project::find($id);
        $project->fill($request->all())->save();
        
        Log::debug('projectテーブルの既存案件を上書きしました');

        return ['success' => '案件を編集しました！'];

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // 応募者がいない場合に登録した案件を削除
    public function destroy($id)
    {
        Log::debug('--------- RestProjectCintroller@destroy ---------');

        if($id && Project::find($id)->where([
            ['close_flg', 0],
            ['delete_flg', 0],
            ['received_user_id', null]
            ])->exists()){
            $project = Project::find($id);
            $project->delete_flg = 1;
            $project->save();

            Log::debug('案件を削除しました');

        return ['success' => '案件を削除しました！'];
        }
    }
}
