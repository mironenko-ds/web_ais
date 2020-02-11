<?php

namespace App\Services;

use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class GetSortEmployee{

    public static function sort($req, $dep_id){
        $get_req = array();
        $value = '';
        $buffer = array();

        switch ($req->input('value')) {
            case '1':
                if($req->input('type-sort') == 'desc'){
                    $value = Employee::orderBy('created_at', 'desc')
                    ->where('department_id', '=', $dep_id)
                    ->with('departament', 'degree', 'post', 'user')
                    ->paginate(15);
                    $get_req['val'] = 1; $get_req['type'] = 'desc';
                    $buffer['value'] = $value; $buffer['get'] = $get_req;
                }else{
                    $value = Employee::orderBy('created_at', 'asc')
                    ->where('department_id', '=', $dep_id)
                    ->with('departament', 'degree', 'post', 'user')
                    ->paginate(15);
                    $get_req['val'] = 1; $get_req['type'] = 'asc';
                    $buffer['value'] = $value; $buffer['get'] = $get_req;
                }
                break;
            case '2':
                if($req->input('type-sort') == 'desc'){
                    $value = Employee::select('employees.*')
                    ->join('posts', 'employees.post_id', '=', 'posts.id', 'left')
                    ->where('department_id', '=', $dep_id)
                    ->orderBy('posts.post_name', 'desc')
                    ->with('departament', 'degree', 'post', 'user')
                    ->paginate(15);

                    $get_req['val'] = 2; $get_req['type'] = 'desc';
                    $buffer['value'] = $value; $buffer['get'] = $get_req;
                }else{
                    $value = Employee::join('posts', 'employees.post_id', '=', 'posts.id', 'left')
                    ->where('department_id', '=', $dep_id)
                    ->orderBy('posts.post_name', 'asc')
                    ->select('employees.*')
                    ->with('departament', 'degree', 'post', 'user')
                    ->paginate(15);
                    $get_req['val'] = 2; $get_req['type'] = 'asc';
                    $buffer['value'] = $value; $buffer['get'] = $get_req;
                }
                break;
            case '3':
                if($req->input('type-sort') == 'desc'){
                    $value = Employee::join('academic_degrees', 'employees.degree_id', '=', 'academic_degrees.id')
                    ->orderBy('degree_name', 'desc')
                    ->where('department_id', '=', $dep_id)
                    ->with('departament', 'degree', 'post', 'user')
                    ->paginate(15);
                    $get_req['val'] = 3; $get_req['type'] = 'desc';
                    $buffer['value'] = $value; $buffer['get'] = $get_req;
                }else{
                    $value = Employee::join('academic_degrees', 'employees.degree_id', '=', 'academic_degrees.id')
                    ->orderBy('degree_name', 'asc')
                    ->where('department_id', '=', $dep_id)
                    ->with('departament', 'degree', 'post', 'user')
                    ->paginate(15);
                    $get_req['val'] = 3; $get_req['type'] = 'asc';
                    $buffer['value'] = $value; $buffer['get'] = $get_req;
                }
                break;
            case '4':
                if($req->input('type-sort') == 'desc'){
                    $value = Employee::orderBy('name', 'desc')
                    ->where('department_id', '=', $dep_id)
                    ->with('departament', 'degree', 'post', 'user')
                    ->paginate(15);
                    $get_req['val'] = 4; $get_req['type'] = 'desc';
                    $buffer['value'] = $value; $buffer['get'] = $get_req;
                }else{
                    $value = Employee::orderBy('name', 'asc')
                    ->where('department_id', '=', $dep_id)
                    ->with('departament', 'degree', 'post', 'user')
                    ->paginate(15);
                    $get_req['val'] = 4; $get_req['type'] = 'asc';
                    $buffer['value'] = $value; $buffer['get'] = $get_req;
                }
                break;
            case '5':
                if($req->input('type-sort') == 'desc'){
                    $value = Employee::orderBy('surname', 'desc')
                    ->where('department_id', '=', $dep_id)
                    ->with('departament', 'degree', 'post', 'user')
                    ->paginate(15);
                    $get_req['val'] = 5; $get_req['type'] = 'desc';
                    $buffer['value'] = $value; $buffer['get'] = $get_req;
                }else{
                    $value = Employee::orderBy('surname', 'asc')
                    ->where('department_id', '=', $dep_id)
                    ->with('departament', 'degree', 'post', 'user')
                    ->paginate(15);
                    $get_req['val'] = 5; $get_req['type'] = 'asc';
                    $buffer['value'] = $value; $buffer['get'] = $get_req;
                }
                break;
            default:
                # code...
                break;
        }
        return $buffer;
    }
}
