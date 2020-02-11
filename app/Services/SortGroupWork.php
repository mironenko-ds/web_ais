<?php

namespace App\Services;

use App\Models\WorkKind;

class SortGroupWork{

    public static function sort($req, $id){
        $questions = '';
        $get_req = array();
        $buffer = array();
        switch ($req->input('value')) {
            case '1':
                if($req->input('type-sort') == 'desc'){
                        $questions =  WorkKind::orderBy('kind_name', 'desc')
                            ->where('type_work_id', '=', $id)
                            ->with('work')
                            ->paginate(15);
                    $get_req['val'] = 1; $get_req['type'] = 'desc';
                    $buffer['value'] = $questions; $buffer['get'] = $get_req;
                }else{
                    $questions =  WorkKind::orderBy('kind_name', 'asc')
                            ->where('type_work_id', '=', $id)
                            ->with('work')
                            ->paginate(15);
                    $get_req['val'] = 1; $get_req['type'] = 'asc';
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
