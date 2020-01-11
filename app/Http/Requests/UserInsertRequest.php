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
            'post.required' => 'Вы не указали свою должность'
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
