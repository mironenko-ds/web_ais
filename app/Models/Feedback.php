<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';

    protected $fillable = ['user_id', 'title', 'content', 'type_user', 'materials', 'status'];

    public function anser(){
        return $this->hasOne('App\Models\FeedbackAnser');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

}
