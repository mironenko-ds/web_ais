<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ValidChangeRequestWork extends FormRequest
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
            'tema.min' => 'Минимальная длина темы должна составлять 6 символов',
            'tema.max' => 'Максимальная длина темы 255 символов',
            'content.required' => 'Вы не указали что нужно изменить',
            'content.min' => 'Минимальна длина сообщения 6 символов',
            'content.max' => 'Максимальная длина сообщения 65535 символов'
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
            'content' => 'required|min:6|max:65535',
        ];
    }
}
