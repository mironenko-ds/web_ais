<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    public $timestamps = true;

    public function user(){
        return $this->hasOne('App\Models\User');
    }
}
