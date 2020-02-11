<?php

namespace App\Services;

use App\Models\Departments;
use App\Models\Employee;

class DeleteUserDepartament{
    public static function delete_user_all_departament($id_departament){
        // delete plan_work
        $result = Employee::where('department_id', '=', $id_departament)
            ->with('plan_work',  'user.feedback.anser')
            ->get();
        // delete plan_work
        foreach ($result as $item) {
            //
            if(isset($item->plan_work)){
                foreach ($item->plan_work as $plan_work) {
                   if(isset($plan_work)){
                        $plan_work->delete();
                   }
                }
            }
        }
        // delete feedback_anser users
        foreach ($result as $employee) {
            if(isset($employee->user->feedback)){
                foreach ($employee->user->feedback as $feedback) {
                    if(isset($feedback->anser)){
                        $feedback->anser->delete();
                    }
                }
            }
        }
        // delete feedback users
        foreach ($result as $employee) {
            if(isset($employee->user->feedback)){
                foreach ($employee->user->feedback as $feedback) {
                    if(isset($feedback)){
                        $feedback->delete();
                    }
                }
            }
        }
        // delete user
        foreach ($result as $employee) {
            if(isset($employee->user)){
                $employee->user->delete();
            }
        }
        // delete employees
        foreach ($result as $employee) {
            if(isset($employee)){
                $employee->delete();
            }
        }
        $dep = Departments::where('id', '=', $id_departament)->first();
        $dep->delete();
    }
}
