<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    public $timestamps = true;
    use SoftDeletes;

    protected $fillable = [
        'name', 'surname', 'patronymic', 'post_id', 'degree_id', 'department_id'
    ];

    public function user(){
        return $this->hasOne('App\Models\User');
    }

    public function plan_work(){
        return $this->hasOne('App\Models\User');
    }

    public function departament(){
        return $this->belongsTo('App\Models\Departments', 'department_id');
    }
    public function degree(){
        return $this->belongsTo('App\Models\AcademicDegree');
    }
    public function post(){
        return $this->belongsTo('App\Models\Post');
    }
}
