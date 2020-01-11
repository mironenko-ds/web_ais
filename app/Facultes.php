<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facultes extends Model
{
    protected $table = 'facultes';

    public function departament(){
        return $this->hasOne('App\Departaments', 'id');
    }
}
