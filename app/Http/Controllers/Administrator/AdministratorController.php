<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AcademicDegree;
use App\Models\Departments;
use App\Models\Employee;
use App\Models\Facultes;
use App\Models\Feedback;
use App\Models\Post;
use App\Services\UserInfoService;


class AdministratorController extends Controller
{
    public function index(){

        return view('administrator.index');
    }

    public function users(){

        $dep_users = Employee::with('departament', 'degree', 'post', 'user')->paginate(10);
        if($dep_users->count()  != 0){
            $posts = Post::all();
            $degrees = AcademicDegree::all();
            $departaments = Departments::all();
            $facultes = Facultes::all();
            $allDep = response()->json($departaments);

            return view('administrator.users', compact('dep_users','posts', 'degrees', 'allDep', 'facultes'));
        }else{
            $UsersEmpty = 'Користувачі відсутні';
            return view('administrator.users', compact('UsersEmpty'));
        }

        return view('administrator.users');
    }

    public function questions(Request $req){
        // if($req->all()){
        //     dd($req->all());

        //     switch ($variable) {
        //         case 'value':
        //             # code...
        //             break;

        //         default:
        //             # code...
        //             break;
        //     }

        // }else


        $questions = Feedback::where([
            ['type_user', '=', 3],
            ['status', '=', false]
        ])->paginate(1);



        if($questions->count() == 0){
            return view('administrator.questions', ['noQuestion' => 'Питань немає']);
        }else{
            return view('administrator.questions', compact('questions'));
        }


        return view('administrator.questions');
    }

    public function management(){

        return view('administrator.management');
    }

    public function account(){

        $info = UserInfoService::info();

        return view('administrator.account', $info);
    }
}
