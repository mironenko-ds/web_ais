<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeedbackAnser extends Model
{
    protected $table = 'feedback-anser';
    use SoftDeletes;

    protected $fillable = ['feedback_id', 'anser', 'asked_user', 'answered_user', 'asked_user_read', 'materials'];

    public function feedback(){
        return $this->belongsTo('App\Models\Feedback');
    }

    public function user_answered(){
        return $this->belongsTo('App\Models\User', 'answered_user');
    }
}
