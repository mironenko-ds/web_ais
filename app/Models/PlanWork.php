<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanWork extends Model
{
    protected $table = "plan_works";

    protected $fillable = ['employee_id', '	departament_id', 'work_id', 'academic_year', 'description',
                        'norm_semester_1_plan', 'norm_semester_2_plan', 'count_plan', '	percentage_plan',
                        'norm_semester_1_fact', 'norm_semester_2_fact', 'count_fact', 'percentage_fact',
                        'materials', 'status', 'title'];
}
