<?php

namespace App\Services;

use App\Models\Work;

class SortWork{

    public static function sort($req, $id){
        $questions = '';
        $get_req = array();
        $buffer = array();
        switch ($req->input('value')) {
            case '1':
                if($req->input('type-sort') == 'desc'){
                    $questions =  Work::orderBy('indicator', 'desc')
                        ->where('works_kinds_id', '=', $id)
                        ->with('work_kind')
                        ->paginate(15);
                    $get_req['val'] = 1; $get_req['type'] = 'desc';
                    $buffer['value'] = $questions; $buffer['get'] = $get_req;
                }else{
                    $questions =  Work::orderBy('indicator', 'asc')
                        ->where('works_kinds_id', '=', $id)
                        ->with('work_kind')
                        ->paginate(15);
                    $get_req['val'] = 1; $get_req['type'] = 'asc';
                    $buffer['value'] = $questions; $buffer['get'] = $get_req;
                }
                break;
            case '2':
                if($req->input('type-sort') == 'desc'){
                    $questions =  Work::orderBy('norm_desc', 'desc')
                        ->where('works_kinds_id', '=', $id)
                        ->with('work_kind')
                        ->paginate(15);
                    $get_req['val'] = 2; $get_req['type'] = 'desc';
                    $buffer['value'] = $questions; $buffer['get'] = $get_req;
                }else{
                    $questions =  Work::orderBy('norm_desc', 'asc')
                        ->where('works_kinds_id', '=', $id)
                        ->with('work_kind')
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
