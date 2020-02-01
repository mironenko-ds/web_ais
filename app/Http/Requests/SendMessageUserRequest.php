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
                'tema.required' => 'Ви не вказали тему!',
                'tema.min' => 'Назва теми має бути більше 6 символів',
                'tema.max' => 'Назва теми має бути не більше 255 символів',
                'type-user.required' => 'Ви не вказали одержувача',
                'type-user.exists' => 'Такого одержувача не існує',
                'content.required' => 'Ви не вказали повідомлення'
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
