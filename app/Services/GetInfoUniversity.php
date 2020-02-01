<?php

namespace App\Services;

use App\Models\AcademicDegree;
use App\Models\Departments;
use App\Models\Facultes;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class GetInfoUniversity{

    public static function get(){

        $result = array();

        $result['posts'] = DB::select('select * from posts');
        $result['degrees'] = DB::select('select * from academic_degrees');
        $result['departaments'] = DB::select('select * from departments');
        $result['facultes'] = DB::select('select * from facultes');
        $result['allDep'] = response()->json(DB::select('select * from departments'));

        return $result;

    }
}
