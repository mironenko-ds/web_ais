<?php

namespace App\Services;

use App\Models\PlanWork;

class SortUserRequestWork{

    public static function sort($req, $id){
        $works = '';
        $get_req = array();
        $buffer = array();

        switch ($req->input('value')) {
            case '1':
                if($req->input('type-sort') == 'desc'){
                    $works = PlanWork::orderBy('title', 'desc')
                        ->where('departament_id', '=', $id)
                        ->with('work')
                        ->paginate(15);
                    $get_req['val'] = 1; $get_req['type'] = 'desc';
                    $buffer['value'] = $works; $buffer['get'] = $get_req;
                }else{
                    $works = PlanWork::orderBy('title', 'asc')
                        ->where('departament_id', '=', $id)
                        ->with('work')
                        ->paginate(15);
                    $get_req['val'] = 1; $get_req['type'] = 'asc';
                    $buffer['value'] = $works; $buffer['get'] = $get_req;
                }
                break;
            case '2':
                if($req->input('type-sort') == 'desc'){
                    $works = PlanWork::orderBy('created_at', 'desc')
                        ->where('departament_id', '=', $id)
                        ->with('work')
                        ->paginate(15);
                    $get_req['val'] = 2; $get_req['type'] = 'desc';
                    $buffer['value'] = $works; $buffer['get'] = $get_req;
                }else{
                    $works = PlanWork::orderBy('created_at', 'asc')
                        ->where('departament_id', '=', $id)
                        ->with('work')
                        ->paginate(15);
                    $get_req['val'] = 2; $get_req['type'] = 'asc';
                    $buffer['value'] = $works; $buffer['get'] = $get_req;
                }
                break;
            case '3':
                if($req->input('type-sort') == 'desc'){
                    $works = PlanWork::orderBy('count_plan', 'desc')
                        ->where('departament_id', '=', $id)
                        ->with('work')
                        ->paginate(15);
                    $get_req['val'] = 3; $get_req['type'] = 'desc';
                    $buffer['value'] = $works; $buffer['get'] = $get_req;
                }else{
                    $works = PlanWork::orderBy('count_plan', 'asc')
                        ->where('departament_id', '=', $id)
                        ->with('work')
                        ->paginate(15);
                    $get_req['val'] = 3; $get_req['type'] = 'asc';
                    $buffer['value'] = $works; $buffer['get'] = $get_req;
                }
                break;
            case '4':
                if($req->input('type-sort') == 'desc'){
                    $works = PlanWork::orderBy('count_fact', 'desc')
                        ->where('departament_id', '=', $id)
                        ->with('work')
                        ->paginate(15);
                    $get_req['val'] = 4; $get_req['type'] = 'desc';
                    $buffer['value'] = $works; $buffer['get'] = $get_req;
                }else{
                    $works = PlanWork::orderBy('count_fact', 'asc')
                        ->where('departament_id', '=', $id)
                        ->with('work')
                        ->paginate(15);
                    $get_req['val'] = 4; $get_req['type'] = 'asc';
                    $buffer['value'] = $works; $buffer['get'] = $get_req;
                }
                break;
            default:
                # code...
                break;
        }

        return $buffer;
    }
}
