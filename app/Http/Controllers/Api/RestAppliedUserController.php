<?php

namespace App\Http\Controllers\Api;

use App\Board;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\AppliedUserController;

class RestAppliedUserController extends Controller
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
    public function store(Request $request)
    {
        Log::debug('--------- AppliedUserController@store ---------');

        $request->validate([
            'received_user_id' => 'required|integer',
            'id' => 'required|integer',
        ]);

        $project = Project::find($request->id);
        $project->fill($request->all())->save();

        Log::debug('projectテーブルにreceived_user_idを保存しました。');

        return ['success' => '受注者を決定しました！'];

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::debug('--------- AppliedUserController@show ---------');
        // Log::debug('$id : '.$id);

        // 案件への応募者がいる場合に応募者データを取得する
        $appliedUsers = null;
        if($id){
            if(Board::where('project_id', $id)->exists()){
                Log::debug('応募者がいます');
                // Log::debug(print_r(Board::where('project_id', $id), true));
            $appliedUsers = Board::where('boards.project_id', $id)
                            ->select(
                                'boards.apply_user_id',
                                'boards.id as boardId',
                                'boards.apply_user_id',
                                'projects.close_flg',
                                'projects.delete_flg',
                                'projects.received_user_id',
                                'users.nickname',
                                'users.profile_img'
                            )
                            ->join('projects', 'boards.project_id', '=', 'projects.id')
                            ->join('users', 'boards.apply_user_id', '=', 'users.id')
                            ->get();
            }else{
                Log::debug('応募者はいません');
            }
        }
        
        return $appliedUsers;
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Log::debug('--------- AppliedUserController@destroy ---------');

        if($id){
        $project = Project::find($id);

        $project->close_flg = 1;

        $project->save();

        return ['success' => '募集を終了しました'];
        }
    }
}
