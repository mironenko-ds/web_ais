<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    protected $table = 'departments';

    protected $fillable = ['departament_name'];

    public function account_creation_request(){
        return $this->hasOne('App\Models\AccountCreationRequest');
    }

    public function employee(){
        return $this->hasOne('App\Models\Employee', 'id');
    }
    public function faculty(){
        return $this->belongsTo('App\Models\Facultes', 'faculty_id');
    }
    public function planWork(){
        return $this->hasOne('App\Models\PlanWork');
    }
}
