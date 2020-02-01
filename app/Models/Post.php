<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = true;

    public function employee(){
        return $this->hasOne('App\Models\Employee');
    }

    public function account_creation_request(){
        return $this->hasOne('App\Models\AccountCreationRequest');
    }
}
