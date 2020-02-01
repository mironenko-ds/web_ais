<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $table = "works";

    public function planWork(){
        return $this->hasOne('App\Models\PlanWork');
    }

    public function work_kind(){
        return $this->belongsTo('App\Models\WorkKind', 'id');
    }
}
