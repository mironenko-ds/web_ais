<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'employee_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(){
        return $this->belongsTo('App\Models\UserRole');
    }

    public function feedback(){
        return $this->hasOne('App\Models\Feedback');
    }

    public function feedbackAnswer(){
        return $this->hasOne('App\Models\FeedbackAnswer');
    }

    public function employee(){
        return $this->belongsTo('App\Models\Employee');
    }

    public function deleteUser(){

    }

    /**
     * The attributes that are mass assignable.
     *
     * @return string
     */
    public function getRole(){

        return $this->role->role_name;
    }

    public function UrlIsLogin(){

        $role = $this->getRole();

        switch ($role) {
            case 'admin':
                return '/admin/index';
                break;
            case 'moderator':
                return '/moderator/index';
                break;
            case 'user':
                return '/user/index';
                break;
            default:
                abort('501');
                break;
        }
    }
}
