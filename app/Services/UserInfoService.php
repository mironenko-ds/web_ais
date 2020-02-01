<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class UserInfoService{

    public static function info(){
        $info = array();
        $user = Auth::user();

        $userName = $user->employee->name;
        $surName = $user->employee->surname;
        $patronymic = $user->employee->patronymic;
        $email = $user->email;
        $facultyName = $user->employee->departament->faculty->faculty_name;
        $departamentName =  $user->employee->departament->departament_name;
        $degreeName = $user->employee->degree->degree_name;
        $userPost = $user->employee->post->post_name;

        return compact('userName', 'surName', 'patronymic', 'email', 'facultyName',
                   'departamentName', 'degreeName', 'userPost');


    }
}
