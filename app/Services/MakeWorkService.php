<?php

namespace App\Services;

use App\Models\PlanWork;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MakeWorkService{

    public static function make($valid){

        $work = new PlanWork;

        $work->employee_id = Auth::user()->employee->id;
        $work->departament_id = Auth::user()->employee->departament->id;
        $work->academic_year = Carbon::now()->year;
        $work->work_id = $valid['work'];
        $work->description = $valid['desc-work'];
        $work->title = $valid['work-title'];
        $work->norm_semester_1_plan = $valid['norma-1-plane'];
        $work->norm_semester_2_plan = $valid['norma-2-plane'];
        $work->count_plan = $valid['count-plane'];
        $work->percentage_plan = $valid['share-plane'];
        $work->norm_semester_1_fact = $valid['norma-1-fact'];
        $work->norm_semester_2_fact = $valid['norma-2-fact'];
        $work->count_fact = $valid['count-fact'];
        $work->percentage_fact = $valid['share-fact'];
        $work->status = false;

        return $work;

    }
}
