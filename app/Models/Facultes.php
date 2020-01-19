<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facultes extends Model
{
    protected $table = 'facultes';

    public function departament(){
        return $this->hasOne('App\Models\Departaments', 'id');
    }
}
