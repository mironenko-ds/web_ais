<?php

namespace App\Services;

use App\Models\Employee;

class AdminSortUser{

    public static function sort($req){
        $get_req = array();
        $users = '';
        $buffer = array();

        switch ($req->input('value')) {
            case '1':
                if($req->input('type-sort') == 'desc'){

                    $users = Employee::orderBy('surname', 'desc')
                            ->with('post', 'degree', 'departament')
                            ->paginate(15);
                    $get_req['val'] = 1; $get_req['type'] = 'desc';
                    $buffer['value'] = $users; $buffer['get'] = $get_req;
                }else{
                    $users = Employee::orderBy('surname', 'asc')
                            ->with('post', 'degree', 'departament')
                            ->paginate(15);
                    $get_req['val'] = 1; $get_req['type'] = 'asc';
                    $buffer['value'] = $users; $buffer['get'] = $get_req;
                }
                break;
            case '2':
                if($req->input('type-sort') == 'desc'){
                    $users = Employee::select('employees.*')
                            ->join('posts', 'employees.post_id', '=', 'posts.id', 'left')
                            ->orderBy('posts.post_name', 'desc')
                            ->with('post', 'degree', 'departament')
                            ->paginate(15);
                    $get_req['val'] = 2; $get_req['type'] = 'desc';
                    $buffer['value'] = $users; $buffer['get'] = $get_req;
                }else{
                    $users = Employee::select('employees.*')
                            ->join('posts', 'employees.post_id', '=', 'posts.id', 'left')
                            ->orderBy('posts.post_name', 'asc')
                            ->with('post', 'degree', 'departament')
                            ->paginate(15);
                    $get_req['val'] = 2; $get_req['type'] = 'asc';
                    $buffer['value'] = $users; $buffer['get'] = $get_req;
                }
                break;
            case '3':
                if($req->input('type-sort') == 'desc'){
                    $users = Employee::select('employees.*')
                    ->join('academic_degrees', 'employees.degree_id', '=', 'academic_degrees.id')
                    ->orderBy('degree_name', 'desc')
                    ->with('post', 'degree', 'departament')
                    ->paginate(15);
                    $get_req['val'] = 3; $get_req['type'] = 'desc';
                    $buffer['value'] =  $users; $buffer['get'] = $get_req;
                }else{
                    $users = Employee::select('employees.*')
                    ->join('academic_degrees', 'employees.degree_id', '=', 'academic_degrees.id')
                    ->orderBy('degree_name', 'asc')
                    ->with('post', 'degree', 'departament')
                    ->paginate(15);
                    $get_req['val'] = 3; $get_req['type'] = 'asc';
                    $buffer['value'] =  $users; $buffer['get'] = $get_req;
                }
                break;
            case '4':
                if($req->input('type-sort') == 'desc'){

                    // $users = Employee::select('employees.*')
                    //     ->join('departments', 'employees.department_id', '=', 'departments.id')
                    //     ->orderBy('departament_name', 'desc')
                    //     ->with('post', 'degree', 'departament')
                    //     ->paginate(15);
                    $users = Employee::select('employees.*')
                        ->join('departments', 'employees.department_id', '=', 'departments.id')
                        ->join('facultes', 'departments.faculty_id', '=', 'facultes.id')
                        ->orderBy('facultes.faculty_name', 'desc')
                        ->with('post', 'degree', 'departament')
                        ->paginate(15);

                    $get_req['val'] = 4; $get_req['type'] = 'desc';
                    $buffer['value'] =  $users; $buffer['get'] = $get_req;
                }else{

                    $users = Employee::select('employees.*')
                        ->join('departments', 'employees.department_id', '=', 'departments.id')
                        ->join('facultes', 'departments.faculty_id', '=', 'facultes.id')
                        ->orderBy('facultes.faculty_name', 'asc')
                        ->with('post', 'degree', 'departament')
                        ->paginate(15);


                    $get_req['val'] = 4; $get_req['type'] = 'asc';
                    $buffer['value'] =  $users; $buffer['get'] = $get_req;
                }
                break;
            case '5':
                if($req->input('type-sort') == 'desc'){
                    $users = Employee::select('employees.*')
                    ->join('departments', 'employees.department_id', '=', 'departments.id')
                    ->orderBy('departament_name', 'desc')
                    ->with('post', 'degree', 'departament')
                    ->paginate(15);
                    $get_req['val'] = 5; $get_req['type'] = 'desc';
                    $buffer['value'] =  $users; $buffer['get'] = $get_req;
                }else{
                    $users = Employee::select('employees.*')
                    ->join('departments', 'employees.department_id', '=', 'departments.id')
                    ->orderBy('departament_name', 'asc')
                    ->with('post', 'degree', 'departament')
                    ->paginate(15);
                    $get_req['val'] = 5; $get_req['type'] = 'asc';
                    $buffer['value'] =  $users; $buffer['get'] = $get_req;
                }
                break;
            case '6':
                if($req->input('type-sort') == 'desc'){

                    $users = Employee::orderBy('created_at', 'desc')
                            ->with('post', 'degree', 'departament')
                            ->paginate(15);
                    $get_req['val'] = 6; $get_req['type'] = 'desc';
                    $buffer['value'] = $users; $buffer['get'] = $get_req;
                }else{
                    $users = Employee::orderBy('created_at', 'asc')
                            ->with('post', 'degree', 'departament')
                            ->paginate(15);
                    $get_req['val'] = 6; $get_req['type'] = 'asc';
                    $buffer['value'] = $users; $buffer['get'] = $get_req;
                }
                break;
            default:
                # code...
                break;
        }

        return $buffer;
    }
}
