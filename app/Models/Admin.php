<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Fortify\TwoFactorAuthenticatable;
class Admin extends Authenticatable
{
    use TwoFactorAuthenticatable;
    //
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'super_admin',
    ];
}
