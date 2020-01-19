<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountCreationRequest extends Model
{
    protected $fillable = ['name', 'surname', 'patronymic', 'email', 'faculty', 'departament', 'degree', 'post', 'password_no_hash'];
}
