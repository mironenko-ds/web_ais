<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcademicDegree extends Model
{
    public $timestamps = true;

    public function employee(){
        return $this->hasOne('App\Employee');
    }
}
