<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $timestamps = true;

    public function user(){
        return $this->hasOne('App\User');
    }

    public function departament(){
        return $this->belongsTo('App\Departments', 'department_id');
    }
    public function degree(){
        return $this->belongsTo('App\AcademicDegree');
    }
    public function post(){
        return $this->belongsTo('App\Post');
    }
}
