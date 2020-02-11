<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicDegree extends Model
{
    public $timestamps = true;
    use SoftDeletes;

    public function employee(){
        return $this->hasOne('App\Models\Employee', 'degree_id');
    }

    public function account_creation_request(){
        return $this->hasOne('App\Models\AccountCreationRequest', 'degree');
    }
}
