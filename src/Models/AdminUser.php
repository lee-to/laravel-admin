<?php

namespace Leeto\Admin\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    protected $fillable = ['email', 'password', 'name', 'avatar'];
}
