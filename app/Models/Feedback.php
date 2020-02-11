<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    protected $table = 'feedback';
    use SoftDeletes;

    protected $fillable = ['user_id', 'title', 'content', 'type_user', 'materials', 'status'];

    public function anser(){
        return $this->hasOne('App\Models\FeedbackAnser', 'feedback_id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function role(){
        return $this->belongsTo('App\Models\UserRole', 'type_user');
    }

}
