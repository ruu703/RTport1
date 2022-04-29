<?php
//new
namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        Log::debug('Auth::user() '.Auth::user());
        Log::debug('$this->id '.$this->id);
        Log::debug('$this->user '.$this->user);
        return [
            // 'profile_img' => 'required|mimes:jpeg,png,jpg,gif|max:1024',
            'file' => 'nullable|mimes:jpeg,png,jpg,gif|max:1024|file',
            'nickname' => 'nullable|string|max:255',
            'email' => ['required','email',Rule::unique('users')->ignore($this->id),'max:255'],// メールアドレス重複チェック
            'introduction' => 'string|nullable|max:1000'
        ];
    }

    public function messages()
    {
        return [
            'file.mimes' => '画像を選択してください。',
            'file.max' => 'ファイルサイズは1MB以下にしてください。'
        ];
    }
}
