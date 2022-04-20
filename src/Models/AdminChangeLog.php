<?php

namespace Leeto\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminChangeLog extends Model
{
    protected $fillable = [
        'admin_user_id',
        'changelogable_id',
        'changelogable_type',
        'states_before',
        'states_after'
    ];

    protected $casts = [
        'states_before' => 'array',
        'states_after' => 'array',
    ];

    public function adminUser()
    {
        return $this->belongsTo(AdminUser::class);
    }

    public function changelogable()
    {
        return $this->morphTo();
    }
}
