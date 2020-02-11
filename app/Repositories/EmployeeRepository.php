<?php

namespace App\Repositories;

use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    /**
    * @param DepartamentId @id
    * @param Status paginate $pug
    */
    public function getByDepartament($id, $pug = false)
    {
        if($pug){
            return Employee::where('department_id', '=', $id)
                ->with('departament');
        }else{
            return Employee::where('department_id', '=', $id)
                ->with('departament', 'degree', 'post', 'user')
                ->get();
        }
    }

    public function all($count)
    {
        return Employee::with('post', 'degree', 'departament')->paginate($count);
    }
}
