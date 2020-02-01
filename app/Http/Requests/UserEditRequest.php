<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Auth::check()){
            return Auth::user()->role->role_name == 'moderator';
        }else{
            return false;
        }
        return false;
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Ви не вказали ім\'я',
            'surname.required'  => 'Ви не вказали прізвище',
            'patronymic.required' => 'Ви не вказали батькові',
            'faculty.required' => 'Ви не вказали факультет',
            'departament.required' => 'Ви не вказали кафедру',
            'degree.required' => 'Ви не вказали вчений ступінь',
            'post.required' => 'Ви не вказали посаду',

            'name.max' => 'Ім\'я не повинно перевищувати 255 символів',
            'surname.max'  => 'Прізвище не повинна перевищувати 255 символів',
            'patronymic.max' => 'Батькові не повинно перевищувати 255 символів',
            'faculty.exists' => 'Ви вказали неіснуючий факультет',
            'departament.exists' => 'Ви вказали неіснуючу кафедру',
            'degree.exists' => 'Ви вказали неіснуючу вчений ступінь',
            'post.exists' => 'Ви вказали неіснуючу посаду'
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
            'faculty' => 'required|exists:facultes,id',
            'departament' => 'required|exists:departments,id',
            'degree' => 'required|exists:academic_degrees,id',
            'post' => 'required|exists:posts,id',
            'user_id' => 'numeric'
        ];
    }
}
