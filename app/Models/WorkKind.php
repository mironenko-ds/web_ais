<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkKind extends Model
{
    protected $table = "works_kinds";

    public function work(){
        return $this->hasOne('App\Models\Work');
    }

    public function typeWork(){
        return $this->belongsTo('App\Models\TypeWork', 'type_work_id');
    }
}
