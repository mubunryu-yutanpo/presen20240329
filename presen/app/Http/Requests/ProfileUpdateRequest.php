<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'avatar' => 'sometimes|nullable|mimes:jpg,jpeg,png,gif,heic,heif|max:8388608', // 8MB'
        ];
    }

    public function messages(){
        return [
            'avatar.mimes' => 'ファイル形式はjpeg(jpg)、png、gif、heic（heif）が利用可能です',
            'avatar.max' => 'ファイルサイズは8MB以下にしてください',
        ];
    }
}
