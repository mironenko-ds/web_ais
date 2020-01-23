<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserInsertRequest extends FormRequest
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
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Вы не указали свое имя',
            'surname.required'  => 'Вы не указали свою фамилию',
            'patronymic.required' => 'Вы не указали свое отчество',
            'email.required' => 'Вы не указали свою почту',
            'faculty.required' => 'Вы не указали свой факультет',
            'departament.required' => 'Вы не указали свою кафедру',
            'degree.required' => 'Вы не указали свою ученую степень',
            'post.required' => 'Вы не указали свою должность',

            'name.max' => 'Имя не должно превышать 255 символов',
            'surname.max'  => 'Фамилия не должна превышать 255 символов',
            'patronymic.max' => 'Отчество не должно превышать 255 символов',
            'email.email' => 'Вы указали не верный формат почты',
            'faculty.exists' => 'Вы указали не существующий факультет',
            'departament.exists' => 'Вы указали не существующую кафедру',
            'degree.exists' => 'Вы указали не существующую ученую степень',
            'post.exists' => 'Вы указали не существующую должность',

            'email.unique' => 'Вы указали не уникальную почту'
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
            'name' => 'required|max:255|string',
            'surname' => 'required|max:255|string',
            'patronymic' => 'required|max:255|string',
            'email' => 'required|email|unique:users,email',
            'faculty' => 'required|exists:facultes,id',
            'departament' => 'required|exists:departments,id',
            'degree' => 'required|exists:academic_degrees,id',
            'post' => 'required|exists:posts,id'
        ];
    }
}
