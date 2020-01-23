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
        'name', 'email', 'password',
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

    public function employee(){
        return $this->belongsTo('App\Models\Employee');
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
                return '/admin/new-user';
                break;
            case 'moderator':
                return '/moderator/page';
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
