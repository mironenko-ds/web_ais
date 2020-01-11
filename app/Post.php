<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = true;
    public function employee(){
        return $this->hasOne('App\Employee');
    }
}
