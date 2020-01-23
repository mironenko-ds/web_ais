<?php

namespace App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class SendMessageUserRequest extends FormRequest
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
                'tema.required' => 'Вы не указали тему!',
                'tema.min' => 'Название темы должно быть больше 6 символов',
                'tema.max' => 'Название темы должно быть не больше 255 символов',
                'type-user.required' => 'Вы не указали пользователя',
                'type-user.exists' => 'Такого типа пользователя не существует',
                'content.required' => 'Вы не указали сообщение'
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
            'tema' => 'required|min:6|max:255',
            'type-user' => 'required|exists:user_roles,id',
            'content' => 'required',
            'attachment[]' => 'file|array'
        ];
    }
}
