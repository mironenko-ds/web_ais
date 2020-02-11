<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departments extends Model
{
    protected $table = 'departments';
    use SoftDeletes;

    protected $fillable = ['departament_name', 'head_departament', 'faculty_id'];

    public function account_creation_request(){
        return $this->hasOne('App\Models\AccountCreationRequest');
    }

    public function employee(){
        return $this->hasOne('App\Models\Employee', 'id');
    }
    public function faculty(){
        return $this->belongsTo('App\Models\Facultes');
    }
    public function planWork(){
        return $this->hasOne('App\Models\PlanWork');
    }
}
