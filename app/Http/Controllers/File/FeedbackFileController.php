<?php

namespace App\Http\Controllers\File;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FeedbackFileController extends Controller
{
    public function getFile($user_id, $folder_hash, $filename){
       $path_file = '/app/uploads/'. $user_id . '/feedback/' . $folder_hash . '/' . $filename;
       $idUser = Auth::user()->id; // user id
       if(Auth::user()->role->role_name == 'admin'){
            return Storage::disk('public')->download($path_file);
       }elseif(Auth::user()->role->role_name == 'moderator'){

            $empUser = User::where('id', '=', $idUser)->first()->employee->departament->id; // владелец файла
            $empModer = Auth::user()->employee->departament->id;
            if($empModer == $empUser){
                return Storage::disk('public')->download($path_file);
            }
       }elseif($idUser == $user_id){
            return Storage::disk('public')->download($path_file);
       }
       return abort(403);
    }
}
