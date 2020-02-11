<?php

namespace App\Services;

use App\Models\AccountCreationRequest;

class GetSortUserRequest{

    public static function sort($requset, $id){
        $get = array();
        $value ='';
        $buffer = array();

        switch ($requset->input('value')) {
            case '1':
                if($requset->input('type-sort') == 'desc'){
                    $value = AccountCreationRequest::orderBy('name', 'desc')
                        ->where('departament', '=', $id)
                        ->with('deg', 'pos')
                        ->paginate(15);
                    $get['val'] = 1; $get['type'] = 'desc';
                    $buffer['value'] = $value; $buffer['get'] = $get;
                }else{
                    $value = AccountCreationRequest::orderBy('name', 'asc')
                        ->where('departament', '=', $id)
                        ->with('deg', 'pos')
                        ->paginate(15);
                    $get['val'] = 1; $get['type'] = 'asc';
                    $buffer['value'] = $value; $buffer['get'] = $get;
                }
                break;
            case '2':
                if($requset->input('type-sort') == 'desc'){
                    $value = AccountCreationRequest::orderBy('email', 'desc')
                        ->where('departament', '=', $id)
                        ->with('deg', 'pos')
                        ->paginate(15);
                    $get['val'] = 2; $get['type'] = 'desc';
                    $buffer['value'] = $value; $buffer['get'] = $get;
                }else{
                    $value = AccountCreationRequest::orderBy('email', 'asc')
                        ->where('departament', '=', $id)
                        ->with('deg', 'pos')
                        ->paginate(15);
                    $get['val'] = 2; $get['type'] = 'asc';
                    $buffer['value'] = $value; $buffer['get'] = $get;
                }
                break;
            case '3':
                if($requset->input('type-sort') == 'desc'){
                      $value = AccountCreationRequest::join('posts', 'posts.id', '=', 'account_creation_requests.post')
                        ->select('account_creation_requests.*')
                        ->orderBy('posts.post_name', 'desc')
                        ->where('departament', '=', $id)
                        ->with('deg', 'pos')
                        ->paginate(15);

                    $get['val'] = 3; $get['type'] = 'desc';
                    $buffer['value'] = $value; $buffer['get'] = $get;

                }else{
                    $value = AccountCreationRequest::join('posts', 'posts.id', '=', 'account_creation_requests.post')
                        ->select('account_creation_requests.*')
                        ->orderBy('posts.post_name', 'asc')
                        ->where('departament', '=', $id)
                        ->with('deg', 'pos')
                        ->paginate(15);
                    $get['val'] = 3; $get['type'] = 'asc';
                    $buffer['value'] = $value; $buffer['get'] = $get;
                }
                break;
            case '4':
                if($requset->input('type-sort') == 'desc'){
                    $value = AccountCreationRequest::join('academic_degrees', 'academic_degrees.id', '=', 'account_creation_requests.degree')
                      ->select('account_creation_requests.*')
                      ->orderBy('academic_degrees.degree_name', 'desc')
                      ->where('departament', '=', $id)
                      ->with('deg', 'pos')
                      ->paginate(15);

                  $get['val'] = 4; $get['type'] = 'desc';
                  $buffer['value'] = $value; $buffer['get'] = $get;

              }else{
                  $value = AccountCreationRequest::join('academic_degrees', 'academic_degrees.id', '=', 'account_creation_requests.degree')
                      ->select('account_creation_requests.*')
                      ->orderBy('academic_degrees.degree_name', 'asc')
                      ->where('departament', '=', $id)
                      ->with('deg', 'pos')
                      ->paginate(15);
                  $get['val'] = 4; $get['type'] = 'asc';
                  $buffer['value'] = $value; $buffer['get'] = $get;
              }
                break;

            default:
                # code...
                break;
        }
        return $buffer;
    }
}
