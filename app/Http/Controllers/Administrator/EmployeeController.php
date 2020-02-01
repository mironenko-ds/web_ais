<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\GetInfoUniversity;
use App\Repositories\EmployeeRepository;


class EmployeeController extends Controller
{
    private $employeeRep;

    public function __construct(EmployeeRepository $em)
    {
        $this->employeeRep = $em;
    }

    public function users(){
        $users = $this->employeeRep->all(15);

        if($users->total() == 0){
            $UsersEmpty = 'Користувачі відсутні';
            return view('administrator.users', compact('UsersEmpty'));
        }else{
            $university = GetInfoUniversity::get();
            return view('administrator.users', compact('users', 'university'));
        }

    }

    public function delete(Request $request){

    }

    public function update(Request $request){

    }
}
