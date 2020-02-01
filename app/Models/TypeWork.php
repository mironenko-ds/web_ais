<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeWork extends Model
{
    protected $table = "type-works";

    public function work_kind(){
        return $this->hasOne('App\Models\WorkKind');
    }
}
