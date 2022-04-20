<?php

namespace Leeto\Admin\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Leeto\Admin\Traits\HasAdminChangeLog;

class AdminUser extends Authenticatable
{
    use HasAdminChangeLog;

    protected $fillable = [
        'email',
        'admin_role_id',
        'password',
        'name',
        'avatar'
    ];

    protected $with = ['adminRole'];

    public function adminRole()
    {
        return $this->belongsTo(AdminRole::class);
    }
}
