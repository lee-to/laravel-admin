<?php

namespace Leeto\Admin\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $fillable = ['email', 'password', 'name', 'avatar'];
}
