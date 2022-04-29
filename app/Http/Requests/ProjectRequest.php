<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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

        $data = $this->all();

        return self::getRules(
            $data['category_id'] 
        );
    }

    public static function getRules($data){

        $rules = [
            'title' => 'required|string|max:255',
            'category_id' => 'required|integer|in:1,2',
            'detail' => 'required|string|max:1000 '
        ];

        // category_idが1(単発案件)の場合のバリデーションルールを追加
        if($data == 1){

            $rules['fee_low'] = 'required | regex:/^[1-9]+[0-9]*000$/';
            $rules['fee_high'] = 'required | regex:/^[1-9]+[0-9]*000$/ | gte:fee_low';

        // category_idが2(レベニューシェア案件)の場合のバリデーションルールを追加
        }else if($data == 2){
            
            $rules['fee_low'] = 'required | regex:/^[1-9]{1}[0-9]?$/';
            $rules['fee_high'] = 'required | regex:/^[1-9]{1}[0-9]?$/ | gte:fee_low';
        }

        return $rules;
    }

    public function messages()
    {
        $data = $this->all();

        $messages = [];
        
        // category_idが1(単発案件)の場合のバリデーションメッセージを追加
        if($data['category_id'] == 1){
            $messages = [
                'fee_low.required' => '報酬 (下限)は必ず入力して下さい。',
                'fee_high.required' => '報酬 (上限)は必ず入力して下さい。',
                'fee_low.min' => '報酬 (下限)は1000円以上で入力して下さい。',
                'fee_low.regex' => '報酬 (下限)は1000円単位で入力して下さい。',
                'fee_high.regex' => '報酬 (上限)は1000円単位で入力して下さい。',
                'fee_high.gte' => '報酬 (上限)は報酬 (下限)以上の値を入力して下さい。'
            ];
        }

        // category_idが2(レベニューシェア案件)の場合のバリデーションメッセージを追加
        if($data['category_id'] == 2){
            $messages = [
                'fee_low.required' => '収益分配率 (下限)は必ず入力して下さい。',
                'fee_high.required' => '収益分配率 (上限)は必ず入力して下さい。',
                'fee_low.regex' => '収益分配率 (下限)は1%単位、1~99%以内で入力して下さい。',
                'fee_high.regex' => '収益分配率 (上限)は1%単位、1~99%以内で入力して下さい。',
                'fee_high.gte' => '収益分配率 (上限)は収益分配率 (下限)以上の値を入力して下さい。'
            ];
        }

        return $messages;
        
    }

}
