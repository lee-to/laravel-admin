<?php

namespace Leeto\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    public static $ADMIN_ROLE_ID = 1;

    protected $fillable = ['name'];

    public function adminUsers()
    {
        return $this->hasMany(AdminUser::class);
    }
}
