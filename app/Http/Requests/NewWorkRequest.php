<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class NewWorkRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function messages()
    {
        return [
            'norma-1-plane.required' => 'Вы не указали норму для первого семестра по плану',
            'norma-1-plane.numeric' => 'Значение: норма для первого семестра должна быть записано в виде числа',
            'norma-2-plane.required' => 'Вы не указали норму для второго семестра по плану',
            'norma-2-plane.numeric' => 'Значение: норма для второго семестра должна быть записано в виде числа',
            'count-plane.required' => 'Вы не указали количество по плану',
            'count-plane.numeric' => 'Количество по плану должно быть записано в виде числа',
            'share-plane.required' => 'Вы не указали долю по плану',
            'share-plane.numeric' => 'Доля по плану должна быть числом',
            'norma-1-fact.required' => 'Вы не указали норму по первому семестру по факту',
            'norma-1-fact.numeric' => 'Норма по факту для первого семестра должна быть записана в виде числа',
            'norma-2-fact.required' => 'Вы не указали норму для второго семестра по факту',
            'norma-2-fact.numeric' => 'Норма по факту для второго семестра должна быть записана в виде числа',
            'share-fact.required' => 'Вы не указали долю по факту',
            'share-fact.numeric' => 'Доля по факту должна быть записана в виде числа',
            'work.required' => 'Вы не указали разновидность работы',
            'work.exists' => 'Такой разновидности работы не существует',
            'work-title.required' => 'Вы не указали название работы',
            'work-title.min' => 'Минимальная длина названия работы состовляет 6 символов',
            'work-title.max' => 'Максимальная длина названия работы 255 символов',
            'desc-work.required' => 'Вы не указали описания работы',
            'desc-work.min' => 'Минимальная длина описания работы 6 символов',
            'desc-work.max' => 'Максимальая длина описания состовляет: 65535 символов'


        ];
    }
    public function rules()
    {
        return [
            'norma-1-plane' => 'required|numeric',
            'norma-2-plane' => 'required|numeric',
            'count-plane' => 'required|numeric',
            'share-plane' => 'required|numeric',
            'norma-1-fact' => 'required|numeric',
            'norma-2-fact' => 'required|numeric',
            'count-fact' => 'required|numeric',
            'share-fact' => 'required|numeric',
            'work' => 'required|exists:works,id',
            'work-title' => 'required|min:6|max:255',
            'desc-work' => 'required|min:6|max:65535'

        ];
    }
}
