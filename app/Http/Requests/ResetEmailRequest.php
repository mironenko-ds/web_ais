<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ResetEmailRequest extends FormRequest
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
            'new-email.required' => 'Вы не указали свою почту',
            'new-email.email' => 'Вы указали не верный формат почты',
            'new-email.unique' => 'Вы указали не уникальную почту'
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
            'new-email' => 'required|email|unique:users,email'
        ];
    }
}
