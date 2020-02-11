<?php

namespace App\Services;

use App\Models\Facultes;

class SortFaculty{

    public static function sort($req){
        $questions = '';
        $get_req = array();
        $buffer = array();
        switch ($req->input('value')) {
            case '1':
                if($req->input('type-sort') == 'desc'){
                    $questions =  Facultes::orderBy('faculty_name', 'desc')
                        ->withCount('departament')
                        ->with('departament')
                        ->paginate(15);
                    $get_req['val'] = 1; $get_req['type'] = 'desc';
                    $buffer['value'] = $questions; $buffer['get'] = $get_req;
                }else{
                    $questions =  Facultes::orderBy('faculty_name', 'asc')
                        ->withCount('departament')
                        ->with('departament')
                        ->paginate(15);
                    $get_req['val'] = 1; $get_req['type'] = 'asc';
                    $buffer['value'] = $questions; $buffer['get'] = $get_req;
                }
                break;
            case '2':
                if($req->input('type-sort') == 'desc'){
                    $questions =  Facultes::orderBy('head_faculty', 'desc')
                        ->withCount('departament')
                        ->with('departament')
                        ->paginate(15);
                    $get_req['val'] = 2; $get_req['type'] = 'desc';
                    $buffer['value'] = $questions; $buffer['get'] = $get_req;
                }else{
                    $questions =  Facultes::orderBy('head_faculty', 'asc')
                        ->withCount('departament')
                        ->with('departament')
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
