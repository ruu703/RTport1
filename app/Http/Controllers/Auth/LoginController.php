<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/mypage';
    // セッションにメッセージを保存してマイページへ遷移
    protected function redirectTo() {
        session()->flash('flash_message', __('Loggedin'));
        return '/mypage';
    }
    
    //　ログイン前のページへ遷移させる
    public function showLoginForm()
    {   
         // $_SERVER->サーバー変数であり、ヘッダ情報やパス情報等を格納しており、この情報はウェブサーバーに依存している->前の画面のリンクを格納している'HTTP_REFERER'や各種サーバーの情報が入っている
       // $_SERVERに'HTTP_REFERER'(前のページのURLを保存する項目)が存在していたら
       if (array_key_exists('HTTP_REFERER', $_SERVER)) {
        // ulr[https://shec003.caelsolus.xyz/show/14]を「scheme->https」「host->shec003.caelsolus.xyz」「pass->/show/14」に分解する
        $path = parse_url($_SERVER['HTTP_REFERER']);  //parse_url-> URL を解釈し、その構成要素(schemeやhost、pass等)を配列で返す
        // dd($path);
            if (array_key_exists('host', $path)) {
                // dd($_SERVER['HTTP_HOST']);
                // ホスト部分どうし(リクエストヘッダーのホストとアプリケーションが存在するサーバーのホスト($_SERVER['HTTP_HOST']で取得可能))で比較する。
                if ($path['host'].':8000' == $_SERVER['HTTP_HOST']) { // ホスト部分が自ホストと同じなら
                    session(['url.intended' => $_SERVER['HTTP_REFERER']]);  //sessionに前回のURLを入れておく->下記のredirectPathアクションで使用する
                }
            }
        }
        
      // session(['url.intended' => $_SERVER['HTTP_REFERER']]);
      return view('auth.login');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // セッションにメッセージを保存してログアウト
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        session()->flash('flash_message', __('logged out'));

        return $this->loggedOut($request) ?: redirect('/');
    }

    // ログイン後の遷移先を指定する
   public function redirectPath(){

        // showLoginFormで保存したsesionのurl.intendedにログインする前のurlが入っている
        $path = \Session::pull('url.intended');
        // dd($path);
        // 案件ページからログインした場合は案件ページへしダイレクト
        if(strpos($path,'project/') !== false){
            return $path;
        }else{
            return '/mypage';
        }
    }
}
