<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = '/mypage';

    protected function redirectTo() {
        session()->flash('flash_message', __('Registered'));
        // return '/mypage';

        $path = \Session::pull('url.intended');
        // dd($path);
        // 案件ページから新規登録した場合は登録後案件ページへリダイレクト
        if(strpos($path,'project/') !== false){
            return $path;
        }else{
            return '/mypage';
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //　ログイン前のページへ遷移させる
        if (array_key_exists('HTTP_REFERER', $_SERVER)) {
            $path = parse_url($_SERVER['HTTP_REFERER']);
            // dd($path);
                if (array_key_exists('host', $path)) {
                    // dd($_SERVER['HTTP_HOST']);
                    // ホスト部分どうし(リクエストヘッダーのホストとアプリケーションが存在するサーバーのホスト($_SERVER['HTTP_HOST']で取得可能))で比較する。
                    if ($path['host'].':8000' == $_SERVER['HTTP_HOST']) { // ホスト部分が自ホストと同じなら
                        session(['url.intended' => $_SERVER['HTTP_REFERER']]);  //sessionに前回のURLを入れておく
                    }
                }
            }

        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            // 'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'check' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            // 'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
