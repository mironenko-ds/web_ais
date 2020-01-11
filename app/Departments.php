<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    protected $table = 'departments';

    public function employee(){
        return $this->hasOne('App\Employee', 'id');
    }
    public function faculty(){
        return $this->belongsTo('App\Facultes', 'faculty_id');
    }
}
