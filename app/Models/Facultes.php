<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facultes extends Model
{
    protected $table = 'facultes';
    use SoftDeletes;

    protected $fillable = ['faculty_name', 'head_faculty'];

    public function departament(){
        return $this->hasMany('App\Models\Departments', 'faculty_id');
    }
}
