<?php

namespace App\Services;

use App\Models\FeedbackAnser;

class ModeratorSortMessage{

    public static function sort($request, $user_id){
        $messages = '';
        $get_req = array();
        $buffer = array();
            switch ($request->input('value')) {
                case '1':
                        if($request->input('type-sort') == 'desc'){
                            $messages = FeedbackAnser::orderBy('asked_user_read', 'desc')
                                ->where('asked_user', '=', $user_id)
                                ->with('user_answered', 'feedback')
                                ->paginate(15);
                            $get_req['val'] = 1; $get_req['type']= 'desc';
                            $buffer['value'] = $messages; $buffer['get'] = $get_req;
                        }else{
                            $messages = FeedbackAnser::orderBy('asked_user_read', 'asc')
                                ->where('asked_user', '=', $user_id)
                                ->with('user_answered', 'feedback')
                                ->paginate(15);
                            $get_req['val'] = 1; $get_req['type']= 'asc';
                            $buffer['value'] = $messages; $buffer['get'] = $get_req;
                        }
                    break;
                case '2':
                        if($request->input('type-sort') == 'desc'){
                            $messages = FeedbackAnser::orderBy('created_at', 'desc')
                                ->where('asked_user', '=', $user_id)
                                ->with('user_answered', 'feedback')
                                ->paginate(15);
                            $get_req['val'] = 2; $get_req['type']= 'desc';
                            $buffer['value'] = $messages; $buffer['get'] = $get_req;
                        }else{
                            $messages = FeedbackAnser::orderBy('created_at', 'asc')
                                ->where('asked_user', '=', $user_id)
                                ->with('user_answered', 'feedback')
                                ->paginate(15);
                            $get_req['val'] = 2; $get_req['type']= 'asc';
                            $buffer['value'] = $messages; $buffer['get'] = $get_req;
                        }
                    break;
                default:
                    # code...
                    break;
            }
        return $buffer;
    }
}
