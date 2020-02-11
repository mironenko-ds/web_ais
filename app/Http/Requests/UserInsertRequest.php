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
            'name.required' => 'Ви не вказали своє ім\'я',
            'surname.required'  => 'Ви не вказали своє прізвище',
            'patronymic.required' => 'Ви не вказали своє по батькові',
            'email.required' => 'Ви не вказали свою пошту',
            'faculty.required' => 'Ви не вказали свій факультет',
            'departament.required' => 'Ви не вказали свою кафедру',
            'degree.required' => 'Ви не вказали свою вчену ступінь',
            'post.required' => 'Ви не вказали свою посаду',

            'name.max' => 'Ім\'я не повинно перевищувати 255 символів',
            'surname.max'  => 'Прізвище не повинна перевищувати 255 символів',
            'patronymic.max' => 'По батькові не повинно перевищувати 255 символів',
            'email.email' => 'Ви вказали неправильний формат пошти',
            'faculty.exists' => 'Ви вказали неіснуючий факультет',
            'departament.exists' => 'Ви вказали неіснуючу кафедру',
            'degree.exists' => 'Ви вказали неіснуючу вчену ступінь',
            'post.exists' => 'Ви вказали неіснуючу посаду',

            'email.unique' => 'Ви вказали не унікальну пошту'
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
