<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\GetInfoUniversity;
use App\Repositories\EmployeeRepository;
use App\Services\AdminSortUser;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    private $employeeRep;

    public function __construct(EmployeeRepository $em)
    {
        $this->employeeRep = $em;
    }

    public function users(Request $request){
        $users = ''; $get_req = array();

        if($request->input('value') && $request->input('type-sort')){
            $val = AdminSortUser::sort($request);
            $users = $val['value']; $get_req = $val['get'];
        }else{
            $users = $this->employeeRep->all(15);
        }

        if($users->total() == 0){
            $UsersEmpty = 'Користувачі відсутні';
            return view('administrator.users', compact('UsersEmpty'));
        }else{
            $university = GetInfoUniversity::get();
            return view('administrator.users', compact('users', 'university', 'get_req'));
        }

    }

    public function deleteUser(Request $request){
        $id = $request->input('user_id');
        try {
            $user = User::where('id', '=', $id)->get()[0];
        } catch (\Throwable $th) {
            return redirect()->route('admin.users');
        }
            $user->delete();
            $user->employee->delete();
            return redirect()->route('admin.users')->with(['successDelete' => 'Користувач був видалений']);
    }

    public function update(Request $request){

    }
}
