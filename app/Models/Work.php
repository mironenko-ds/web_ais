<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Work extends Model
{
    protected $table = "works";
    use SoftDeletes;

    protected $fillable = ['works_kinds_id', 'indicator', 'norm_desc', 'norm-point', 'norm-hour', 'description'];

    public function plan_work(){
        return $this->hasMany('App\Models\PlanWork', 'work_id');
    }

    public function work_kind(){
        return $this->belongsTo('App\Models\WorkKind', 'id');
    }
}
