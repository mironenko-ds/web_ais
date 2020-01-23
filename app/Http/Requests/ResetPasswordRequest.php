<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    public function messages()
    {
        return [
            'new-password.required' => 'Вы не указали новый пароль',
            'new-password.min' => 'Пароль должен быть длинее 6 символов',
            'new-password.max' => 'Пароль должен быть не больше 16 символов',
            'new-password.same' => 'Пароли не совпадают'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old-password' => 'required',
            'new-password' => 'required|min:8|max:16|same:replay-password'
        ];
    }
}
