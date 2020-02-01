<?php

namespace App\Services;

use App\Models\Feedback;
use App\Services\AddFileService;
use Illuminate\Support\Facades\Auth;

class SendUserMessage{

    public static function send($title, $content, $user_id, $type_user = 2, $files = null){

        $message = new Feedback;

        $message->title = $title;
        $message->user_id = $user_id;
        $message->content = $content;
        $message->type_user = $type_user;
        $message->status = '0';
        $message->departament_id = Auth::user()->employee->department_id;

        if($files != null){
            $files = new AddFileService($files);
            $json = $files->sendFileToFolder('feedback');  // отправляем файлы в папку app/uploads/{id}/works/hash/files
            $message->materials = json_encode($json);
        }

        return $message;

    }
}
