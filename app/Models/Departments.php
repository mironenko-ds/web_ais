<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    protected $table = 'departments';

    public function employee(){
        return $this->hasOne('App\Models\Employee', 'id');
    }
    public function faculty(){
        return $this->belongsTo('App\Models\Facultes', 'faculty_id');
    }
}
