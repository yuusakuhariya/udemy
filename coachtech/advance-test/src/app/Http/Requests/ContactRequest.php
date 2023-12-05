<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'email' => 'required|email',
            // 郵便番号はハイフンあり、半角、８文字
            'postcode' => 'required|regex:/^[0-9]{3}-[0-9]{4}$/u',
            'address' => 'required',
            'option' => 'required|max:120'
            
        ];
    }

    // 郵便番号は全角の場合は自動で半角に変換
    protected function prepareForValidation()
    {
        $this->merge([
            'postcode' => mb_convert_kana($this->input('postcode'), 'as'),
        ]);
    }

    public function messages()
    {
        return [
            'first_name.required' => '苗字を入力して下さい', 
            'last_name.required' => '名前を入力して下さい', 
            'gender.required' => '選択して下さい',
            'email.required' => 'メールアドレスを入力して下さい',
            'email.email' => '形式をメールアドレスにして下さい',
            'postcode.required' => '郵便番号を入力して下さい',
            'postcode.regex' => '郵便番号は半角の数字とハイフンの形式で入力してください',
            'address.required' => '住所を入力して下さい',
            'option.required' => '入力して下さい',
            'option.max' => '120字以内で入力して下さい',
        ];
    }
}
