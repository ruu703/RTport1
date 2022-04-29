<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectFormController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request ,$id = '0')
    {
        if(!ctype_digit($id)){
            return redirect('/')->with('flash_message', __('Invalid operation was performed.'));
        }

        // フォーム画面の新規登録画面、登録済み案件編集の表示切替用フラグ
        $editflg = ($id)? 0 :  1;

        return view('project.projectform', compact('editflg'));
    }
}
