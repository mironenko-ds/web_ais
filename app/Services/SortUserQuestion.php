<?php

namespace App\Services;

use App\Models\Feedback;

class SortUserQuestion{

    public static function sort($req, $user_id, $user_dep){
        $questions = '';
        $get_req = array();
        $buffer = array();
        switch ($req->input('value')) {
            case '1':
                if($req->input('type-sort') == 'desc'){
                    $questions = Feedback::orderBy('title', 'desc')
                        ->where([
                            ['user_id', '<>', $user_id],
                            ['type_user', '=', 2],
                            ['departament_id', '=', $user_dep],
                            ['status', '=', false]
                        ])
                        ->with('user')
                        ->paginate(15);
                    $get_req['val'] = 1; $get_req['type'] = 'desc';
                    $buffer['value'] = $questions; $buffer['get'] = $get_req;
                }else{
                    $questions = Feedback::orderBy('title', 'asc')
                        ->where([
                            ['user_id', '<>', $user_id],
                            ['type_user', '=', 2],
                            ['departament_id', '=', $user_dep],
                            ['status', '=', false]
                        ])
                        ->with('user')
                        ->paginate(15);
                    $get_req['val'] = 1; $get_req['type'] = 'asc';
                    $buffer['value'] = $questions; $buffer['get'] = $get_req;
                }
                break;
            case '2':
                if($req->input('type-sort') == 'desc'){
                    $questions = Feedback::orderBy('created_at', 'desc')
                        ->where([
                            ['user_id', '<>', $user_id],
                            ['type_user', '=', 2],
                            ['departament_id', '=', $user_dep],
                            ['status', '=', false]
                        ])
                        ->with('user')
                        ->paginate(15);
                    $get_req['val'] = 2; $get_req['type'] = 'desc';
                    $buffer['value'] = $questions; $buffer['get'] = $get_req;
                }else{
                    $questions = Feedback::orderBy('created_at', 'asc')
                        ->where([
                            ['user_id', '<>', $user_id],
                            ['type_user', '=', 2],
                            ['departament_id', '=', $user_dep],
                            ['status', '=', false]
                        ])
                        ->with('user')
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
