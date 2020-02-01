<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class IdDepartament{

    public static function get(){
        return Auth::user()->employee->departament->id;
    }
}
