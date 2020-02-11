<?php

namespace App\Services;

use App\Models\Departments;

class SortDepart{

    public static function sort($req, $id){
        $questions = '';
        $get_req = array();
        $buffer = array();
        switch ($req->input('value')) {
            case '1':
                if($req->input('type-sort') == 'desc'){
                        $questions =  Departments::orderBy('departament_name', 'desc')
                            ->where('faculty_id', '=', $id)
                            ->paginate(15);
                    $get_req['val'] = 1; $get_req['type'] = 'desc';
                    $buffer['value'] = $questions; $buffer['get'] = $get_req;
                }else{
                    $questions =  Departments::orderBy('departament_name', 'asc')
                    ->where('faculty_id', '=', $id)
                    ->paginate(15);
                    $get_req['val'] = 1; $get_req['type'] = 'asc';
                    $buffer['value'] = $questions; $buffer['get'] = $get_req;
                }
                break;
            case '2':
                if($req->input('type-sort') == 'desc'){
                    $questions =  Departments::orderBy('head_departament', 'desc')
                    ->where('faculty_id', '=', $id)
                    ->paginate(15);
                    $get_req['val'] = 2; $get_req['type'] = 'desc';
                    $buffer['value'] = $questions; $buffer['get'] = $get_req;
                }else{
                    $questions =  Departments::orderBy('head_departament', 'asc')
                            ->where('faculty_id', '=', $id)
                            ->paginate(15);
                    $get_req['val'] = 2; $get_req['type'] = 'asc';
                    $buffer['value'] = $questions; $buffer['get'] = $get_req;
                }
                break;
            default:
                # code...
                break;
        }

        return $buffer;
    }
}
