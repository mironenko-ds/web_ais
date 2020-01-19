<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $timestamps = true;

    public function user(){
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
