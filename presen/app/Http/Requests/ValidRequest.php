<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            //viewで設定している各フォームのname属性の名前
            'name' => 'sometimes|required|string|max:20',
            'email' => 'sometimes|required|string|max:255',
            'password' => 'sometimes|required|string|max:255|min:8',
            'password_re' => 'sometimes|required|same:password',
            'introduction' => 'sometimes|nullable|string|max:300',
            'avatar' => 'sometimes|nullable|mimes:jpg,jpeg,png,gif,heic,heif|max:8388608', // 8MB'
            'title' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|integer',
            'thumbnail' => 'sometimes|nullable|mimes:jpg,jpeg,png,gif,heic,heif|max:8388608', // 8MB'
            'price'   => 'sometimes|nullable|min:0|max:9999999999|regex:/^[0-9]+$/i',
            'comment' => 'sometimes|nullable|string|max:255',
            'content' => 'sometimes|required|string|max:2000',
        ];
    }

    public function messages()
    {
        return [
            //バリデーションのエラーメッセージ設定
            'type.required' => '選択してください',
            'price.min' => '0未満は設定できません',
            'price.max' => '9,999,999,999円(9999999999)以内で設定してください',
            'avatar.mimes' => 'ファイル形式はjpeg(jpg)、png、gif、heic（heif）が利用可能です',
            'avatar.max' => 'ファイルサイズは8MB以下にしてください',
            'thumbnail.mimes' => 'ファイル形式はjpeg(jpg)、png、gif、heic（heif）が利用可能です',
            'thumbnail.max' => 'ファイルサイズは8MB以下にしてください',
            'content.max' => '2,000文字以内で入力してください',
        ];
    }
}
