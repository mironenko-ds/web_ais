<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkKind extends Model
{
    protected $table = "works_kinds";
    use SoftDeletes;

    public function work(){
        return $this->hasMany('App\Models\Work', 'works_kinds_id');
    }

    public function typeWork(){
        return $this->belongsTo('App\Models\TypeWork', 'type_work_id');
    }
}
