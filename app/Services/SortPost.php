<?php

namespace App\Services;

use App\Models\Post;

class SortPost{

    public static function sort($req){
        $questions = '';
        $get_req = array();
        $buffer = array();
        switch ($req->input('value')) {
            case '1':
                if($req->input('type-sort') == 'desc'){
                        $questions =  Post::orderBy('post_name', 'desc')
                            ->paginate(15);
                    $get_req['val'] = 1; $get_req['type'] = 'desc';
                    $buffer['value'] = $questions; $buffer['get'] = $get_req;
                }else{
                    $questions =  Post::orderBy('post_name', 'asc')
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
